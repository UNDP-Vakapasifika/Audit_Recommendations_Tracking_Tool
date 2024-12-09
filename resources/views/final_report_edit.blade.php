@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Change Implementation Status</h3>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
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
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <div class="flex justify-between items-center">
                        <!-- <a href="{{route('status.change.summary')}}" class="">Changes Summary</a> -->
                        <x-primary-button>
                            <a href="{{ route('status.change.summary') }}"
                            class="font-semibold text-l text-grey-500 leading-tight">
                            <i class="fa fa-gear"></i> Changes Summary
                            </a>
                        </x-primary-button>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>

                    <div class="flex flex-col md:flex-row mt-3 justify-between md:items-center">
                        <h2 class="text-xl text-center font-bold mb-4">All Audit Reports</h2>
                        <!-- Search Input Field -->
                        <input type="text" id="searchInputReports" placeholder="Search..." class="mb-4 px-4 py-2 border rounded">
                    </div>

                    <table class="w-full border border-gray-200"
                        style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                        <thead>
                        <tr>
                            <th class="table-header">Audit Report Title</th>
                            <th class="table-header">Client</th>
                            <th class="table-header">Publication Date</th>
                            <th class="table-header">Responsible Person</th>
                        </tr>
                        </thead>
                        <tbody id="tableBodyReports">
                            <!-- Loop through each report detail -->
                            @foreach($uniqueReportDetails2 as $reportDetails)
                                <tr>
                                    <!-- Link to the final report details page using the report ID -->
                                    <td class="border border-gray-200 px-4 py-2 text-blue-500 hover:underline">
                                        <a href="{{ route('final.report.details', ['id' => $reportDetails['id']]) }}">
                                            {{ $reportDetails['reportTitle'] }}
                                        </a>
                                    </td>
                                    <!-- Display lead body name -->
                                    <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['client'] }}</td>

                                    <!-- Display creation date -->
                                    <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['dateCreated'] }}</td>

                                    <!-- Display responsible person name -->
                                    <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['sai_responsible_person'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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

        document.getElementById('searchInputReports').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyReports tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>


@endsection
