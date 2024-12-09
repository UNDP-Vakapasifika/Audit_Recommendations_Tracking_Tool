@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-between md:items-center">
        <h3 class="page-heading">
            {{ __('Final Reports Tracking') }}
        </h3>
        <div class="flex gap-2 items-center">
            @if(auth()->user()->can('change final report status'))
                <!-- <x-primary-button>
                    <a href="{{ route('notes.unique.reports') }}"
                    class="font-semibold text-l text-grey-500 leading-tight"><i class="fa fa-gear"></i>
                        Notes
                    </a>                
                </x-primary-button> -->

                <x-primary-button>
                    <a href="{{ route('notes.unique.reports') }}"
                    class="font-semibold text-l text-grey-500 leading-tight">
                    <i class="fa fa-gear"></i> Notes <span class="badge">({{ $totalNotes }})</span>
                    </a>
                </x-primary-button>

            @endif

            @if(auth()->user()->can('change final report status'))
                <x-primary-button>
                    <a href="{{ route('edit.finalreport') }}"
                    class="font-semibold text-l text-grey-500 leading-tight"><i class="fa fa-gear"></i>
                        Change Status
                    </a>                
                </x-primary-button>
            @endif

            <div x-data="{ showModal: false }">
                <!-- Button to open the modal -->
                @if(auth()->user()->can('upload recommendations'))
                    <x-primary-button @click="showModal = true" class="font-semibold text-l text-grey-500 leading-tight">
                        <i class="fa fa-arrow-up"></i> {{ __(' Upload Final Report') }}
                    </x-primary-button>
                @endif

                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-0 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div x-show="showModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <!-- Modal Panel -->
                        <div x-show="showModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('upload.recommendations.post2') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="p-6">
                                    <div class="mb-4">
                                        <label for="excelDoc" class="block text-sm font-medium text-gray-700">Choose a CSV file</label>
                                        <input type="file" name="excelDoc" id="excelDoc" class="mt-1 p-2 border rounded-md w-full">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center p-6 bg-gray-50">
                                    <x-primary-button type="submit">
                                        <i class="fa fa-arrow-up"></i> {{ __(' Upload CSV') }}
                                    </x-primary-button>

                                    <x-primary-button onclick="cancelAndReload(event)">
                                        <i class="fa fa-times"></i> {{ __('Cancel') }}
                                    </x-primary-button>

                                    <script>
                                        function cancelAndReload(event) {
                                            event.preventDefault();
                                            location.reload();
                                        }
                                    </script>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 rounded relative mt-4" role="alert">
        <strong class="font-bold">Error:</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 close-button cursor-pointer">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 10.586l2.293-2.293a1 1 0 111.414 1.414L11.414 12l2.293 2.293a1 1 0 01-1.414 1.414L10 13.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 12 6.293 9.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </span>
    </div>
    @endif

    <div class="py-4">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between md:items-center">
                        <h2 class="text-xl text-center font-bold mb-4">Tracking Final Report</h2>
                        <input type="text" id="reportSearchInput" placeholder="Search Audit Reports..." class="mb-4 px-4 py-2 border rounded">
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="w-full border border-gray-200 table-auto min-w-full" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                    <th class="border border-gray-200 px-4 py-2">Client</th>
                                    <th class="border border-gray-200 px-4 py-2">SAI Responsible Person</th>
                                    <th class="border border-gray-200 px-4 py-2">Head of Audited Entity</th>
                                    <th class="border border-gray-200 px-4 py-2">Date Created</th>
                                    <!-- @if(auth()->user()->can('create final report cautions'))
                                    <th class="border border-gray-200 px-4 py-2">Action</th>
                                    @endif -->
                                </tr>
                            </thead>
                            <tbody id="reportTableBody">
                                @foreach($uniqueReportDetails2 as $reportDetails)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2 text-blue-500 hover:underline">
                                            <a href="{{ route('report.details3', ['id' => $reportDetails['id']]) }}">
                                                {{ Str::limit($reportDetails['reportTitle'], 40) }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['leadBody'] }}</a></td>
                                        <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['createdPerson'] }}</a></td>
                                        <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['AuditedEntityHead'] }}</a></td>
                                        <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['dateCreated'] }}</a></td>
                                        <!-- @if(auth()->user()->can('create final report cautions'))
                                        <td class="border border-gray-200 px-4 py-2">
                                            <a href="{{ route('report.details3', ['id' => $reportDetails['id']]) }}" class="text-blue-500">Caution</a>
                                        </td>
                                        @endif -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- For 30 days remaining -->
    <div class="py-10">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between md:items-center">
                        <h2 class="text-xl text-center font-bold mb-4">Less than 30 Days</h2>
                        <input type="text" id="searchInput30Days" placeholder="Search Due in 30 Days..." class="mb-4 px-4 py-2 border rounded">
                    </div>
                    @if($actionPlans2->isEmpty())
                        <div style="overflow-x: auto;">
                            <table class="w-full border border-gray-200 table-auto min-w-full" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                        <th class="border border-gray-200 px-4 py-2">Client</th>
                                        <th class="border border-gray-200 px-4 py-2">Date Created</th>
                                        <th class="border border-gray-200 px-4 py-2">Created Person</th>
                                        @if(auth()->user()->can('create final report cautions'))
                                        <th class="border border-gray-200 px-4 py-2">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="w-full border border-gray-200 table-auto min-w-full" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Client</th>
                                        <th class="border border-gray-200 px-4 py-2">Client Type</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                        <th class="border border-gray-200 px-4 py-2">Recommendation</th>
                                        <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                        <th class="border border-gray-200 px-4 py-2">Days Remaining</th>
                                        <th class="border border-gray-200 px-4 py-2">Reason Not Implemented</th>
                                        <th class="border border-gray-200 px-4 py-2">Responsible Person</th>
                                        @if(auth()->user()->can('create final report cautions'))
                                        <th class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 2;">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="tableBody30Days">
                                    @foreach($actionPlans2 as $actionPlan)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->client_name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->client_type_name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->audit_report_title }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->audit_recommendations }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->current_implementation_status }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @if($actionPlan->days_remaining >= 0)
                                                    {{ $actionPlan->days_remaining }} days remaining
                                                @else
                                                    {{ abs($actionPlan->days_remaining) }} days remaining
                                                @endif
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->reason_not_implemented }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->responsible_person_name }}</td>
                                            @if(auth()->user()->can('create final report cautions'))
                                            <td class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 1;">
                                                <a href="{{ route('report.details.view', $actionPlan->id) }}" class="text-blue-500">Caution</a>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- For past days -->
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between md:items-center">
                        <h2 class="text-xl text-center font-bold mb-4">Past Due Days</h2>
                        <input type="text" id="searchInputPastDue" placeholder="Search Due Recom..." class="mb-4 px-4 py-2 border rounded">
                    </div>              
                    @if($actionPlans3->isEmpty())
                        <div style="overflow-x: auto;">
                            <table class="w-full border border-gray-200 table-auto min-w-full" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Client</th>
                                        <th class="border border-gray-200 px-4 py-2">Client Type</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                        <th class="border border-gray-200 px-4 py-2">Date Created</th>
                                        <th class="border border-gray-200 px-4 py-2">Created Person</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="w-full border border-gray-200 table-auto min-w-full" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Client</th>
                                        <th class="border border-gray-200 px-4 py-2">Client Type</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                        <th class="border border-gray-200 px-4 py-2">Recommendation</th>
                                        <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                        <th class="border border-gray-200 px-4 py-2">Past Due Days</th>
                                        <th class="border border-gray-200 px-4 py-2">Reason Not Implemented</th>
                                        <th class="border border-gray-200 px-4 py-2">Responsible Person</th>
                                        @if(auth()->user()->can('create final report cautions'))
                                        <th class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 2;">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="tableBodyPastDue">
                                    @foreach($actionPlans3 as $actionPlan)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->client_name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->client_type_name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                <a href="{{ route('report.details3', ['id' => $actionPlan['id']]) }}">
                                                    {{ $actionPlan->audit_report_title }}
                                                </a>
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->audit_recommendations }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->current_implementation_status }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @if($actionPlan->days_remaining >= 0)
                                                    {{ $actionPlan->days_remaining }} days overdue
                                                @else
                                                    {{ abs($actionPlan->days_remaining) }} days overdue
                                                @endif
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->reason_not_implemented }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $actionPlan->responsible_person_name }}</td>
                                            @if(auth()->user()->can('create final report cautions'))
                                                <td class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 1;">
                                                    <a href="{{ route('report.details.view', $actionPlan->id) }}" class="text-blue-500">Caution</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const closeButtons = document.querySelectorAll('.close-button');

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.parentElement.style.display = 'none';
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            function filterTable(inputId, tableBodyId) {
                const input = document.getElementById(inputId);
                const tableBody = document.getElementById(tableBodyId);
                const rows = tableBody.getElementsByTagName('tr');

                input.addEventListener('keyup', function () {
                    const filter = input.value.toLowerCase();

                    for (let i = 0; i < rows.length; i++) {
                        const cells = rows[i].getElementsByTagName('td');
                        let textContent = '';
                        for (let j = 0; j < cells.length; j++) {
                            textContent += cells[j].textContent.toLowerCase() + ' ';
                        }
                        rows[i].style.display = textContent.includes(filter) ? '' : 'none';
                    }
                });
            }

            // Initialize filter for the report table
            filterTable('reportSearchInput', 'reportTableBody');
        });
        
        document.getElementById('searchInput30Days').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBody30Days tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('searchInputPastDue').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyPastDue tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>

@endsection
