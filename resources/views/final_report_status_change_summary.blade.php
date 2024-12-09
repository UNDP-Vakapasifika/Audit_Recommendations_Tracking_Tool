@extends('layouts.master')

@section('body')
    <div class="flex justify-between items-center">
        <h3 class="page-heading">Summary of Changes</h3>

        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
    </div>
    @if(session('success'))
        <div class="bg-green-500 text-white p-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <!-- Search Input Field -->
                        <input type="text" id="searchInputChanges" placeholder="Search..." class="mb-4 px-4 py-2 border rounded">
                        
                        <table class="w-full border-collapse table-auto">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2 whitespace-nowrap">Audit Report Title</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">Audit Recommendations</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">From Status</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">To Status</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">From Date</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">To Date</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">Evidence</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">Impact</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">Changed By</th>
                                    <th class="border px-4 py-2 whitespace-nowrap">Change Date</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyChanges">
                                @forelse($changes as $change)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $change->finalReport->audit_report_title }}</td>
                                        <td class="border px-4 py-2">{{ $change->finalReport->audit_recommendations }}</td>
                                        <td class="border px-4 py-2">{{ $change->from_status }}</td>
                                        <td class="border px-4 py-2">{{ $change->to_status }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($change->from_date)->format('d, M Y') }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($change->to_date)->format('d, M Y') }}</td>
                                        <td class="border px-4 py-2">
                                            @if($change->evidence)
                                                @php
                                                    $ext = pathinfo($change->evidence, PATHINFO_EXTENSION);
                                                @endphp
                                                <a href="{{ asset($change->evidence) }}" target="_blank" download>Download Evidence</a>
                                                @if ($ext == 'pdf')
                                                    <svg width="24" height="24" fill="currentColor" class="text-red-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19 13H5v-2h14v2zm0-4H5V7h14v2zm0 8H5v-2h14v2z"></path>
                                                    </svg>
                                                @elseif ($ext == 'doc' || $ext == 'docx')
                                                    <svg width="24" height="24" fill="currentColor" class="text-blue-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 14H9v-2h6v2zm0 4H9v-2h6v2zm0-8H9V6h6v2z"></path>
                                                    </svg>
                                                @endif
                                            @else
                                                No Evidence
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            @if($change->impact)
                                                @php
                                                    $ext = pathinfo($change->impact, PATHINFO_EXTENSION);
                                                @endphp
                                                <a href="{{ asset($change->impact) }}" target="_blank" download>Download Impact</a>
                                                @if ($ext == 'pdf')
                                                    <svg width="24" height="24" fill="currentColor" class="text-red-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M19 13H5v-2h14v2zm0-4H5V7h14v2zm0 8H5v-2h14v2z"></path>
                                                    </svg>
                                                @elseif ($ext == 'doc' || $ext == 'docx')
                                                    <svg width="24" height="24" fill="currentColor" class="text-blue-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 14H9v-2h6v2zm0 4H9v-2h6v2zm0-8H9V6h6v2z"></path>
                                                    </svg>
                                                @endif
                                            @else
                                                No Impact
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $change->user->name ?? 'Unknown' }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($change->created_at)->format('d, M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="border px-4 py-2 text-center">No changes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('searchInputChanges').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBodyChanges tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>

@endsection
