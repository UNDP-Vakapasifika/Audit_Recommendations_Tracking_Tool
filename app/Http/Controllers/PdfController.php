<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use App\Models\User;
use App\Models\Tool;
use App\Models\FinalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PDF;


class PdfController extends Controller
{
    public function generateChartsAndPdf()
    {
        $tool = Tool::first(); // Get the first tool, or modify as needed

        // Generate bar graph image with status counts
        $statuses = ['No Update', 'Not Implemented', 'Partially Implemented'];
        $recommendationsByStatus = FinalReport::select('current_implementation_status', \DB::raw('count(*) as count'))
            ->whereIn('current_implementation_status', $statuses)
            ->groupBy('current_implementation_status')
            ->pluck('count', 'current_implementation_status')->toArray();
        $this->generateBarGraph($recommendationsByStatus);

        // Generate pie chart image
        $this->generatePieChart();

        // generateDoughnutChart chart image
        $this->generateDoughnutChart();

        // Fetch the first created stakeholder
        $stakeholder = Stakeholder::oldest()->first();

        if (!$stakeholder) {
            return response()->json(['message' => 'No stakeholder found'], 404);
        }

        // Fetch the user with the role of "Head of SAI" affiliated to the retrieved stakeholder
        $headOfSAI = User::whereHas('stakeholder', function ($query) use ($stakeholder) {
            $query->where('id', $stakeholder->id);
        })->whereHas('roles', function ($query) {
            $query->where('name', 'Head of SAI');
        })->first();

        // dd($headOfSAI);

        if (!$headOfSAI) {
            return response()->json(['message' => 'No Head of SAI found for the stakeholder'], 404);
        }


        // Fetch recommendations data
        $statuses = ['No Update', 'Not Implemented', 'Partially Implemented'];
        $recommendationsNotFullyImplemented = FinalReport::whereIn('current_implementation_status', $statuses)->count();
        $recommendationsByStatus = FinalReport::select('current_implementation_status', \DB::raw('count(*) as count'))
            ->whereIn('current_implementation_status', $statuses)
            ->groupBy('current_implementation_status')
            ->get();

        $publicationDateRange = FinalReport::select(\DB::raw('MIN(publication_date) as start_date, MAX(publication_date) as end_date'))
            ->whereIn('current_implementation_status', $statuses)
            ->first();

        $totalRecommendations = FinalReport::count();
        $fullyImplementedCount = FinalReport::where('current_implementation_status', 'Fully Implemented')->count();
        $NoUpdateCount = FinalReport::where('current_implementation_status', 'No Update')->count();

        // Get unique audit report titles from final_reports table
        $auditReportTitles = FinalReport::distinct('audit_report_title')->pluck('audit_report_title');

        // Initialize an empty array to store table data
        $tableData = [];

        // Loop through each audit report title
        foreach ($auditReportTitles as $title) {
            // Count the number of resolved recommendations for the current audit title
            $resolvedRecommendationsCount = FinalReport::where('audit_report_title', $title)
                ->where('current_implementation_status', '!=', 'Fully Implemented')
                ->count();

            // Get the publication date of the latest report with this title
            $latestReport = FinalReport::where('audit_report_title', $title)
                ->orderBy('publication_date', 'desc')
                ->first();

            // Add the data to the table array
            $tableData[] = [
                'audit_report_title' => $title,
                'description' => 'N/A', // Default description
                'publication_date' => $latestReport ? $latestReport->publication_date : 'N/A',
                'resolved_recommendations_count' => $resolvedRecommendationsCount,
            ];
        }

        // Fetch unresolved recommendations from the final reports table
        $unresolvedRecommendations = FinalReport::where('current_implementation_status', '!=', 'Fully Implemented')
        ->join('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
        ->select(
            'lead_bodies.name as audited_entity',
            'final_reports.audit_report_title',
            'final_reports.publication_date',
            'final_reports.page_par_reference',
            'final_reports.audit_recommendations',
            'final_reports.current_implementation_status',
            'final_reports.follow_up_date as entity_proposed_completion_date',
            'final_reports.acceptance_status',
            'final_reports.target_completion_date as actual_expected_implementation_date',
            'final_reports.summary_of_response as audited_entity_response'
        )
        ->get();

    // Fetch recommendations with a gender dimension from the final reports table
    $genderDimensionRecommendations = FinalReport::where('mainstream_categories_id', '!=', null)
        ->whereHas('mainstreamCategory', function ($query) {
            $query->where('name', '!=', 'Not Applicable');
        })
        ->join('lead_bodies', 'final_reports.client_id', '=', 'lead_bodies.id')
        ->join('mainstream_categories', 'final_reports.mainstream_categories_id', '=', 'mainstream_categories.id')
        ->select(
            'lead_bodies.name as audited_entity',
            'final_reports.audit_report_title',
            'final_reports.publication_date',
            'final_reports.page_par_reference',
            'final_reports.audit_recommendations',
            'mainstream_categories.name as mainstreaming_category',
            'final_reports.current_implementation_status',
            'final_reports.follow_up_date as entity_proposed_completion_date',
            'final_reports.acceptance_status',
            'final_reports.target_completion_date as actual_expected_implementation_date',
            'final_reports.summary_of_response as audited_entity_response'
        )->get();

        $tool = Tool::first();

        // Prepare data for the view
        $data = [
            'countryName' => $stakeholder->name,
            'location' => $stakeholder->location,
            'postalAddress' => $stakeholder->postal_address,
            'telephone' => $stakeholder->telephone,
            'email' => $stakeholder->email,
            'website' => $stakeholder->website,
            'barChartImageUrl' => public_path('img/bar_graph.png'),
            'pieChartImageUrl' => public_path('img/pie_chart.png'),
            'DoughnutChartImageUrl' => public_path('img/doughnut_chart.png'),
            'headOfSAI' => $headOfSAI->name,
            'recommendationsNotFullyImplemented' => $recommendationsNotFullyImplemented,
            'recommendationsByStatus' => $recommendationsByStatus,
            'publicationDateRange' => $publicationDateRange,
            'fullyImplementedCount' => $fullyImplementedCount,
            'NoUpdateCount' => $NoUpdateCount,
            'resolvedRecommendations' => $tableData,
            'unresolvedRecommendations' => $unresolvedRecommendations,
            'genderDimensionRecommendations' => $genderDimensionRecommendations,
            'tool' => $tool,
            
        ];

        $html = View::make('parliament_report', $data)->render();

        // Generate PDF without triggering download
        $pdf = PDF::loadHTML($html)->setPaper('a3', 'landscape');

        // Get the raw PDF content
        $pdfContent = $pdf->output();

        // Set the content type
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        // Return the PDF content as a response without triggering download
        return response($pdfContent, 200, $headers);
    }

    public function generateBarGraph(array $statusCounts)
    {
        // Define graph dimensions
        $width = 600;
        $height = 400;
        $padding = 30;
    
        // Create image resource
        $image = imagecreatetruecolor($width, $height);
    
        // Define colors
        $bgColor = imagecolorallocate($image, 255, 255, 255); // White background
        $axisColor = imagecolorallocate($image, 0, 0, 0); // Black axis
        $barColors = [
            'Fully Implemented' => imagecolorallocate($image, 0, 255, 0), // Green
            'Partially Implemented' => imagecolorallocate($image, 255, 255, 0), // Yellow
            'No Update' => imagecolorallocate($image, 255, 165, 0), // Orange
            'Not Implemented' => imagecolorallocate($image, 255, 0, 0), // Red
        ];
    
        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
    
        // Calculate dimensions
        $barCount = count($statusCounts);
        $barWidth = ($barCount > 0) ? ($width - 2 * $padding) / $barCount : 0; // Avoid division by zero
    
        // Determine the maximum value
        $maxValue = ($barCount > 0) ? max($statusCounts) : 0; // Handle empty array
        $scaleY = ($maxValue > 0) ? ($height - 2 * $padding) / $maxValue : 0; // Avoid division by zero
    
        // Draw bars
        $startX = $padding;
        foreach ($statusCounts as $status => $count) {
            $barColor = $barColors[$status] ?? $barColors['Not Implemented']; // Default color if status not found
            $x1 = $startX;
            $y1 = $height - $padding;
            $x2 = $x1 + $barWidth - 1;
            $y2 = $height - $padding - $count * $scaleY;
            imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);
            $startX += $barWidth;
        }
    
        // Draw X and Y axes
        imageline($image, $padding, $height - $padding, $width - $padding, $height - $padding, $axisColor); // X axis
        imageline($image, $padding, $padding, $padding, $height - $padding, $axisColor); // Y axis
    
        // Add scale to Y axis
        $scaleStep = ($maxValue > 0) ? $maxValue / 5 : 1; // Avoid division by zero
        for ($i = 0; $i <= 5; $i++) {
            $y = $height - $padding - $i * $scaleStep * $scaleY;
            imageline($image, $padding - 5, $y, $padding, $y, $axisColor); // Scale lines
            imagestring($image, 5, 5, $y - 8, round($i * $scaleStep), $axisColor); // Scale labels
        }
    
        // Save image to file
        $filePath = public_path('img/bar_graph.png');
        imagepng($image, $filePath);
    
        // Free memory
        imagedestroy($image);
    }
    
    
    public function generatePieChart()
    {
        // Fetch counts of recommendations by implementation status
        $statuses = ['Fully Implemented', 'Partially Implemented', 'No Update', 'Not Implemented'];
        $recommendationsByStatus = FinalReport::select('current_implementation_status', \DB::raw('count(*) as count'))
            ->whereIn('current_implementation_status', $statuses)
            ->groupBy('current_implementation_status')
            ->pluck('count', 'current_implementation_status')
            ->toArray();
    
        // Calculate percentages and labels
        $totalRecommendations = array_sum($recommendationsByStatus);
        $percentages = [];
        $labels = [];
        foreach ($recommendationsByStatus as $status => $count) {
            $percentage = round(($count / $totalRecommendations) * 100, 2);
            $percentages[$status] = $percentage;
            $labels[] = $status . ': ' . $percentage . '%';
        }
    
        // Draw the pie chart
        $width = 600;
        $height = 400;
        $pieChartImage = imagecreatetruecolor($width, $height);
        $backgroundColor = imagecolorallocate($pieChartImage, 255, 255, 255);
        imagefill($pieChartImage, 0, 0, $backgroundColor);
    
        $colors = [
            'Fully Implemented' => imagecolorallocate($pieChartImage, 0, 255, 0),
            'Partially Implemented' => imagecolorallocate($pieChartImage, 255, 255, 0),
            'No Update' => imagecolorallocate($pieChartImage, 255, 165, 0),
            'Not Implemented' => imagecolorallocate($pieChartImage, 255, 0, 0),
        ];
    
        $startAngle = 0;
        foreach ($percentages as $status => $percentage) {
            $endAngle = $startAngle + ($percentage / 100) * 360;
            imagefilledarc($pieChartImage, 200, 150, 200, 200, $startAngle, $endAngle, $colors[$status], IMG_ARC_PIE);
            $startAngle = $endAngle;
        }
    
        // Add legends outside the chart
        $legendX = 420;
        $legendY = 100;
        $legendSpacing = 20;
        $index = 0;
        foreach ($percentages as $status => $percentage) {
            imagefilledrectangle($pieChartImage, $legendX, $legendY + ($index * $legendSpacing), $legendX + 15, $legendY + 15 + ($index * $legendSpacing), $colors[$status]);
            imagettftext($pieChartImage, 10, 0, $legendX + 20, $legendY + 12 + ($index * $legendSpacing), imagecolorallocate($pieChartImage, 0, 0, 0), public_path('fonts/arial.ttf'), $labels[$index]);
            $index++;
        }
    
        // Add labels just below the chart
        // $labelX = 100;
        // $labelY = 350;
        // $labelsString = implode('  |  ', $labels);
        // imagettftext($pieChartImage, 12, 0, $labelX, $labelY, imagecolorallocate($pieChartImage, 0, 0, 0), public_path('fonts/arial.ttf'), $labelsString);
    
        // Save the image
        $pieChartImagePath = public_path('img/pie_chart.png');
        imagepng($pieChartImage, $pieChartImagePath);
        imagedestroy($pieChartImage);
    }
    

    public function generateDoughnutChart()
    {
        // Fetch counts of recommendations by implementation status
        $statuses = ['Fully Implemented', 'Partially Implemented', 'No Update', 'Not Implemented'];
        $recommendationsByStatus = FinalReport::select('current_implementation_status', \DB::raw('count(*) as count'))
            ->whereIn('current_implementation_status', $statuses)
            ->groupBy('current_implementation_status')
            ->pluck('count', 'current_implementation_status')
            ->toArray();
    
        // Initialize counts for missing statuses
        foreach ($statuses as $status) {
            if (!isset($recommendationsByStatus[$status])) {
                $recommendationsByStatus[$status] = 0;
            }
        }
    
        // Calculate total recommendations
        $totalRecommendations = array_sum($recommendationsByStatus);
    
        // Create a new image resource for the doughnut chart
        $image = imagecreatetruecolor(400, 400);
    
        // Allocate colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $colors = [
            'Fully Implemented' => imagecolorallocate($image, 0, 255, 0),
            'Partially Implemented' => imagecolorallocate($image, 255, 255, 0),
            'No Update' => imagecolorallocate($image, 255, 165, 0),
            'Not Implemented' => imagecolorallocate($image, 255, 0, 0),
        ];
    
        // Fill the background with white
        imagefilledrectangle($image, 0, 0, 399, 399, $white);
    
        // Draw the doughnut chart segments
        $startAngle = 0;
        $cx = 200;
        $cy = 200;
        $radius = 100;
    
        if ($totalRecommendations > 0) {
            foreach ($statuses as $status) {
                $count = $recommendationsByStatus[$status];
                $percentage = ($count / $totalRecommendations) * 360;
    
                // Draw segment
                imagefilledarc($image, $cx, $cy, $radius * 2, $radius * 2, $startAngle, $startAngle + $percentage, $colors[$status], IMG_ARC_PIE);
    
                // Update start angle for the next segment
                $startAngle += $percentage;
            }
        } else {
            // If there are no recommendations, draw a blank chart
            imagestring($image, 5, 150, 190, 'No Data Available', $black);
        }
    
        // Save the doughnut chart image as PNG
        $doughnutChartImagePath = public_path('img/doughnut_chart.png');
        imagepng($image, $doughnutChartImagePath);
    
        // Free up memory
        imagedestroy($image);
    }
    
    
}
