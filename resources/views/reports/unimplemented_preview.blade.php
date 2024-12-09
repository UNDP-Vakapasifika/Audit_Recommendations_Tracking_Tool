<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unimplemented Report</title>
    <style>
        /* Include Tailwind CSS */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');

        /* Custom styles for PDF */
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px; /* Reduce font size */
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed; /* Ensure table fits within page */
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 4px; /* Reduce padding */
            text-align: left;
            word-wrap: break-word; /* Ensure content wraps within cell */
        }

        .table th {
            background-color: #f2f2f2;
        }

        header {
            text-align: left;
            margin-bottom: 6px;
        }
    </style>
</head>
<body class="bg-white text-black">

    <header>
        <h1 class="text-2xl font-bold">Unimplemented Recommendations Report</h1>
        <p class="text-lg">Government Accounting Information Systems</p>
    </header>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Client</th>
                    <th class="border px-4 py-2">Audit Report Title</th>
                    <th class="border px-4 py-2">Date of Audit</th>
                    <th class="border px-4 py-2">Publication Date</th>
                    <th class="border px-4 py-2">Page Par Reference</th>
                    <th class="border px-4 py-2">Audit Recommendations</th>
                    <th class="border px-4 py-2">Classification</th>
                    <!-- <th class="border px-4 py-2">Client</th> -->
                    <th class="border px-4 py-2">Client Type</th>
                    <th class="border px-4 py-2">Mainstream Category</th>
                    <th class="border px-4 py-2">Responsible Person</th>
                    <th class="border px-4 py-2">Current Implementation Status</th>
                    <th class="border px-4 py-2">Target Completion Date</th>
                    <th class="border px-4 py-2">Follow Up Date</th>
                    <th class="border px-4 py-2">Action Plan</th>
                    <th class="border px-4 py-2">Responsible Person</th>
                    <th class="border px-4 py-2">SAI Confirmation</th>
                    <th class="border px-4 py-2">Head of Audited Entity</th>
                    <th class="border px-4 py-2">Audited Entity Focal Point</th>
                    <th class="border px-4 py-2">Audit Team Lead</th>
                    <th class="border px-4 py-2">Summary of Response</th>
                </tr>
            </thead>
            <tbody>
                <!-- Check if the final reports array is empty -->
                @if ($unimplementedReports->isEmpty())
                    <!-- Display a message indicating that there are no records -->
                    <tr>
                        <td colspan="21" class="border px-4 py-2 text-center">No final reports found.</td>
                    </tr>
                @else
                    @foreach($unimplementedReports as $unimplementedReport)
                        <tr>
                            <td class="border px-4 py-2">{{ $unimplementedReport->leadBody->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->audit_report_title }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->date_of_audit->format('d, M Y') }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->publication_date->format('d, M Y') }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->page_par_reference }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->audit_recommendations }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->classification }}</td>
                            <!-- <td class="border px-4 py-2">{{ $unimplementedReport->leadBody->name }}</td> -->
                            <td class="border px-4 py-2">{{ $unimplementedReport->clientType->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->mainstreamCategory->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->saiResponsiblePerson->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->current_implementation_status }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->target_completion_date->format('d, M Y') }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->follow_up_date->format('d, M Y') }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->action_plan }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->saiResponsiblePerson->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->sai_confirmation }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->headOfAuditedEntity->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->auditedEntityFocalPoint->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->auditTeamLead->name }}</td>
                            <td class="border px-4 py-2">{{ $unimplementedReport->summary_of_response }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</body>
</html>
