@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Unimplemented Report</h3>
        <div class="flex gap-2 items-center">
            @if(auth()->user()->can('view final report'))
                <a href="{{ route('audit-reports.download') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 w-fit">
                    <!-- Print Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V3h12v6m0 0h2a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2m0 0v4H6v-4m12 0H6m0 0v-2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2m-4-2V7m-4 2h4" />
                    </svg>
                    Print
                </a>
            @endif
        </div>
    </div>
    <p class="pt-1 text-gray-800">
        Scroll along the table to view all the data
    </p>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4"></h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <div style="overflow-x: auto;">
                        <table id="example" class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Audited Entity</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                    <th class="border border-gray-200 px-4 py-2">Date of Audit</th>
                                    <th class="border border-gray-200 px-4 py-2">Publication Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Page Par Reference</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Recommendations</th>
                                    <th class="border border-gray-200 px-4 py-2">Classification</th>
                                    <th class="border border-gray-200 px-4 py-2">Client</th>
                                    <th class="border border-gray-200 px-4 py-2">Client Type</th>
                                    <th class="border border-gray-200 px-4 py-2">Mainstream Category</th>
                                    <th class="border border-gray-200 px-4 py-2">Responsible Person</th>
                                    <th class="border border-gray-200 px-4 py-2">Current Implementation Status</th>
                                    <th class="border border-gray-200 px-4 py-2">Target Completion Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Follow Up Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Action Plan</th>
                                    <th class="border border-gray-200 px-4 py-2">Responsible Person</th>
                                    <th class="border border-gray-200 px-4 py-2">SAI Confirmation</th>
                                    <th class="border border-gray-200 px-4 py-2">Head of Audited Entity</th>
                                    <th class="border border-gray-200 px-4 py-2">Audited Entity Focal Point</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Team Lead</th>
                                    <th class="border border-gray-200 px-4 py-2">Summary of Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Check if the final reports array is empty -->
                                @if ($unimplementedReports->isEmpty())
                                    <!-- Display a message indicating that there are no records -->
                                    <tr>
                                        <td colspan="19" class="border border-gray-200 px-4 py-2">No final reports found.</td>
                                    </tr>
                                @else
                                    @foreach($unimplementedReports as $unimplementedReport)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->leadBody->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->audit_report_title }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->date_of_audit->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->publication_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->page_par_reference }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->audit_recommendations }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->classification }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->leadBody->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->clientType->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->mainstreamCategory->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->saiResponsiblePerson->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->current_implementation_status }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->target_completion_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->follow_up_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->action_plan }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->saiResponsiblePerson->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->sai_confirmation }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->headOfAuditedEntity->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->auditedEntityFocalPoint->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->auditTeamLead->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $unimplementedReport->summary_of_response }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <!-- Include Laravel Echo and Pusher libraries -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Including custom JavaScript file -->
    <script src="{{ asset('js/unimplementedReportListener.js') }}"></script>

    <script>
        // Initialize Laravel Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
        });
    </script>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({

                "columnDefs": [{
                    "orderable": false,
                    "targets": 5
                }],

                "lengthChange": false,
            });
        });
    </script>
@endsection
