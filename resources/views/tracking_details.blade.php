@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Final Report Tracking</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4">{{ $reportDetails[0]->audit_report_title }}</h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <div style="overflow-x: auto;">
                        <!-- Search Input Field -->
                        <input type="text" id="searchInputReportDetails" placeholder="Search..." class="mb-4 px-4 py-2 border rounded">
                        
                        <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Client</th>
                                    <th class="border border-gray-200 px-4 py-2">Client Type</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Recommendations</th>
                                    <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                    <th class="border border-gray-200 px-4 py-2">Remaining|Overdue Days</th>
                                    <th class="border border-gray-200 px-4 py-2">Target Completion Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Follow Up Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Reason Not Implemented</th>
                                    @if(auth()->user()->can('create final report cautions'))
                                        <th class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 2;">Action</th>
                                    @endif 
                                </tr>
                            </thead>
                            <tbody id="tableBodyReportDetails">
                                @foreach($reportDetails as $details)
                                    <tr>
                                        <!-- Display client name -->
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->leadBody->name }}</td>
                                        <!-- Display client type name -->
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->client_type_name }}</td>
                                        <!-- Display audit recommendations with a limit on the length of the string -->
                                        <td class="border border-gray-200 px-4 py-2">{{ Str::limit($details->audit_recommendations, 40) }}</td>
                                        <!-- Display current implementation status -->
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->current_implementation_status }}</td>
                                        <!-- Display days remaining -->
                                        <td class="border border-gray-200 px-4 py-2">
                                            @if($details->days_remaining >= 0)
                                                {{ $details->days_remaining }} days remaining
                                            @else
                                                {{ abs($details->days_remaining) }} days overdue
                                            @endif
                                        </td>
                                        <!-- Display target completion date -->
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->target_completion_date->format('d, M Y') }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->follow_up_date->format('d, M Y') }}</td>
                                        <!-- Display reason not implemented -->
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->reason_not_implemented }}</td>
                                        <!-- Display caution link if the user has permission -->
                                        @if(auth()->user()->can('create final report cautions'))
                                            <td class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 1;">
                                                <a href="{{ route('report.details.view', $details->id) }}" class="text-blue-500">Caution</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('searchInputReportDetails').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyReportDetails tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>

@endsection
