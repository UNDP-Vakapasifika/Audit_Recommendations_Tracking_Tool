@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-between md:items-center">
        <h3 class="page-heading">
            {{ __('Final Reports Notes') }}
        </h3>
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
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl text-center font-bold mb-4">Notable Reports</h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>

                    <!-- Search Input Field -->
                    <input type="text" id="searchInputReportsDetails" placeholder="Search..." class="mb-4 px-4 py-2 border rounded">

                    <div style="overflow-x: auto;">
                        <table class="w-full border border-gray-200 table-auto min-w-full" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                    <th class="border border-gray-200 px-4 py-2">Client</th>
                                    <th class="border border-gray-200 px-4 py-2">SAI Responsible Person</th>
                                    <th class="border border-gray-200 px-4 py-2">Head of Client</th>
                                    <th class="border border-gray-200 px-4 py-2">Date Uploaded</th>
                                    <!-- @if(auth()->user()->can('create final report cautions'))
                                    <th class="border border-gray-200 px-4 py-2">Action</th>
                                    @endif -->
                                </tr>
                            </thead>
                            <tbody id="tableBodyReportsDetails">
                                @foreach($uniqueReportDetails2 as $reportDetails)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2 text-blue-500 hover:underline">
                                            <a href="{{ route('notes.unique.details', ['id' => $reportDetails['id']]) }}">
                                                {{ Str::limit($reportDetails['reportTitle'], 40) }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['leadBody'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['createdPerson'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['AuditedEntityHead'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $reportDetails['dateCreated'] }}</td>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const closeButtons = document.querySelectorAll('.close-button');

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.parentElement.style.display = 'none';
                });
            });
        });

        document.getElementById('searchInputReportsDetails').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyReportsDetails tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });

    </script>

@endsection
