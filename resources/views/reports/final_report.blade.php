@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        Final Report
    </h3>
    <p class="pt-1 text-gray-800">
        Scroll along the table to view or delete the recommendations
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
                                    <th class="border border-gray-200 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Check if the final reports array is empty -->
                                @if ($finalReports->isEmpty())
                                    <!-- Display a message indicating that there are no records -->
                                    <tr>
                                        <td colspan="19" class="border border-gray-200 px-4 py-2">No final reports found.</td>
                                    </tr>
                                @else
                                    @foreach($finalReports as $finalReport)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->leadBody->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->audit_report_title }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->date_of_audit->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->publication_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->page_par_reference }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->audit_recommendations }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->classification }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->leadBody->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->clientType->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->mainstreamCategory->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->saiResponsiblePerson->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->current_implementation_status }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->target_completion_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->follow_up_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->action_plan }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->saiResponsiblePerson->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->sai_confirmation }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->headOfAuditedEntity->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->auditedEntityFocalPoint->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->auditTeamLead->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $finalReport->summary_of_response }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                <div class="flex space-x-2"> <!-- Flex container for inline buttons -->

                                                    <!-- Delete Button -->
                                                    <form class="delete_item" action="{{ route('recommendations.destroy', $finalReport->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete Record" data-toggle="tooltip" class="text-red-500 hover:text-red-700">
                                                            <!-- Delete Icon -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('final.recommendations.edit', $finalReport->id) }}" class="inline-flex items-center text-blue-500 hover:text-blue-700">
                                                        <!-- Edit Icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5a1 1 0 011-1h5a1 1 0 011 1v5a1 1 0 01-1 1h-5a1 1 0 01-1-1V5zm-1 10.586l2 2L17.586 12a2 2 0 00-2.828-2.828l-4.758 4.758a2 2 0 00-.414.414l-2 2a1 1 0 00-.293.707V17h.586a1 1 0 00.707-.293l.707-.707zm-2.293 3.293a1 1 0 001.414 0l7-7a1 1 0 00-1.414-1.414l-7 7a1 1 0 000 1.414z" />
                                                        </svg>
                                                        <!-- Edit Text -->
                                                        <span class="ml-2">Edit</span>
                                                    </a>

                                                </div>
                                            </td>
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
    <script src="{{ asset('js/finalReportListener.js') }}"></script>

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
