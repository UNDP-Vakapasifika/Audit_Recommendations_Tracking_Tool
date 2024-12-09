@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">All Reports</h3>
        <div class="flex gap-2 items-center">
            @if(auth()->user()->can('view final report'))
                <a href="{{ route('finalreport') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 w-fit">
                    View|Delete Recommendations
                </a>
            @endif
            @if(auth()->user()->can('view final report'))
                <a href="{{ route('unimplemented.report') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 w-fit">
                    Unimplemented Report
                </a>
            @endif
        </div>
    </div>

    @php
        $tables = [
            ['title' => 'Fully Implemented Recommendations', 'id' => 'fully_implemented', 'data' => $implementedRecommendations],
            ['title' => 'Partially Implemented Recommendations', 'id' => 'partly_implemented', 'data' => $partiallyImplementedRecommendations],
            ['title' => 'Not Implemented Recommendations', 'id' => 'not_implemented', 'data' => $notImplementedRecommendations],
            ['title' => 'No Update Recommendations', 'id' => 'noupdate_implementation', 'data' => $noupdateImplementedRecommendations],
            ['title' => 'No Longer Applicable Recommendations', 'id' => 'no_longer_applicable', 'data' => $noLongerApplicableRecommendations],
        ];
    @endphp

    @foreach ($tables as $table)
        <div class="max-w-7xl mx-auto pt-4">
            <h3 class="page-subheading">{{ $table['title'] }}</h3>
            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                        <table class="w-full border border-gray-200 table-auto min-w-full" style="border-collapse: collapse; white-space: nowrap;" id="{{ $table['id'] }}">
                            <thead>
                                <tr>
                                    <th class="table-header">Client Name</th>
                                    <th class="table-header">Report Title</th>
                                    <th class="table-header">Audit Date</th>
                                    <th class="table-header">SAI Responsible Person</th>
                                    <th class="table-header">Number of Recommendations</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50" style="position: sticky; right: 0; z-index: 2; background: white;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @php
                                    // Group recommendations by report title and count them
                                    $groupedRecommendations = $table['data']->groupBy('audit_report_title');
                                @endphp

                                @foreach ($groupedRecommendations as $reportTitle => $recommendations)
                                    @php
                                        // Get the first recommendation to display non-redundant data
                                        $firstRecommendation = $recommendations->first();
                                        // Count the number of recommendations for this report title
                                        $recommendationCount = $recommendations->count();
                                    @endphp
                                    <tr>
                                        <td class="table-row-data">{{ $firstRecommendation->client->name }}</td>
                                        <td class="table-row-data">{{ Str::limit($reportTitle, 20, '...') }}</td>
                                        <td class="table-row-data">{{ $firstRecommendation->date_of_audit->format('d, M Y') }}</td>
                                        <td class="table-row-data">{{ $firstRecommendation->responsiblePerson->name }}</td>
                                        <td class="table-row-data">{{ $recommendationCount }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium" style="position: sticky; right: 0; z-index: 1; background: white;">
                                            <a href="{{ route('final.report.details', ['id' => $firstRecommendation->id, 'status' => $table['id']]) }}" class="text-blue-600 hover:text-blue-900">Details</a>
                                        </td>
                                    </tr>
                                @endforeach

                                @empty($table['data'])
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-700" colspan="6">No recommendations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#fully_implemented, #partly_implemented, #not_implemented, #noupdate_implementation, #no_longer_applicable').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 5
                }],
                "lengthChange": false,
            });
        });
    </script>
@endsection
