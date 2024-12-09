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
                            <tbody>
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
                                                @if ($ext == 'pdf')
                                                    <svg width="24" height="24" fill="currentColor" class="text-red-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 13H5v-2h14v2zm0-4H5V7h14v2zm0 8H5v-2h14v2z"></path></svg>
                                                    <a href="{{ asset('storage/' . $change->evidence) }}" target="_blank">Download Evidence</a>
                                                @elseif ($ext == 'doc' || $ext == 'docx')
                                                    <svg width="24" height="24" fill="currentColor" class="text-blue-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15 14H9v-2h6v2zm0 4H9v-2h6v2zm0-8H9V6h6v2z"></path></svg>
                                                    <a href="{{ asset('storage/' . $change->evidence) }}" target="_blank">Download Evidence</a>
                                                @else
                                                    <span>Unknown File Type</span>
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
                                                @if ($ext == 'pdf')
                                                    <svg width="24" height="24" fill="currentColor" class="text-red-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 13H5v-2h14v2zm0-4H5V7h14v2zm0 8H5v-2h14v2z"></path></svg>
                                                    <a href="{{ asset('storage/' . $change->impact) }}" target="_blank">Download Impact</a>
                                                @elseif ($ext == 'doc' || $ext == 'docx')
                                                    <svg width="24" height="24" fill="currentColor" class="text-blue-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15 14H9v-2h6v2zm0 4H9v-2h6v2zm0-8H9V6h6v2z"></path></svg>
                                                    <a href="{{ asset('storage/' . $change->impact) }}" target="_blank">Download Impact</a>
                                                @else
                                                    <span>Unknown File Type</span>
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
@endsection


                <div class="py-10 pt-[110px] top-section">
                    <div class=" mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class=" bg-white border border-gray-200 p-4">
                                <div class="charts grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-1 py-4 rounded-lg mb-4">
                                    <div class="card" style="display: inline-block;">
                                        <canvas id="myChart1" width="200" height="200"></canvas>
                                    </div>
                                    <div class="card" style="display: inline-block;">
                                        <canvas id="myChart2" width="200" height="200"></canvas>
                                    </div>
                                    <div class="card" style="display: inline-block;">
                                        <canvas id="myChart3" width="200" height="200"></canvas>
                                    </div>
                                    <div class="card" style="display: inline-block;">
                                        <canvas id="myChart4" width="200" height="200"></canvas>
                                    </div>
                                </div>
                                <hr class="border-blue-600 mb-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <div class="grid grid-cols-1 gap-1 border border-gray-200 rounded-lg p-4">
                                        <div class="lg:col-span-1 sm:col-span-1 md:col-span-1">
                                            <h1 class="font-semibold text-xl text-blue-800 leading-tight lg:mb-2 col-span-2">Overview</h1>
                                            <p class="col-span-1">Number of Clients: <span class="font-bold text-blue-800">{{ $totalLeadBodies }}</span></p>
                                            <p class="sm:col-span-2">Number of Audits: <span class="font-bold text-blue-800">{{ $totalReportTitles }}</span></p>
                                            <p class="col-span-2">Number of Repeated Findings: <span class="font-bold text-blue-800">{{ $totalRecurrence }}</span></p>
                                            <p class="sm:col-span-1">Number of Recommendations: <span class="font-bold text-blue-800">{{ $totalRecommendationsCount }}</span></p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-1 border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-center col-span-2 mb-4">
                                            <h1 class="font-bold text-xl text-blue-800 leading-tight">Filter
                                                Section
                                            </h1>
                                            <button type="button" onclick="clearFilters()"
                                                class="border border-blue-700 text-blue-500 hover:bg-blue-500 hover:text-white font-bold py-2 px-4 rounded-lg lg:h-10 sm:h-20 md:h-10">Filtered Report
                                                </button>
                                            <button type="button" onclick="clearFilters()"
                                                class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-2 px-4 rounded-lg lg:h-10 sm:h-20 md:h-10">Clear
                                                Filters</button>
                                        </div>
                                        <!-- Filter by Client Office Form -->
                                        <form method="get" action="{{ route('home2') }}"
                                            class="my-form filter-form col-span-2">
                                            @csrf
                                            <div class="dropdown-container mb-4 lg:flex lg:justify-between">
                                                <div class="mb-4 lg:mb-0 lg:w-1/2 sm:w-full md:w-full lg:mr-4">
                                                    <label for="filter_country_office" class="">Filter by Client:</label>
                                                    <select name="filter_country_office" id="filter_country_office"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                        onchange="submitForm()">
                                                        <option value=""
                                                            {{ empty($selectedFilters['filter_country_office']) ? 'selected' : '' }}>
                                                            All</option>
                                                        @foreach ($distinctLeadBodies as $office)
                                                            <option value="{{ $office }}"
                                                                {{ isset($selectedFilters['filter_country_office']) && $selectedFilters['filter_country_office'] == $office ? 'selected' : '' }}>
                                                                {{ $office }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4 lg:mb-0 lg:w-1/2 md:w-full sm:w-full">
                                                    <label for="filter_audit_report_title" class="">Filter by
                                                        Report Title:</label>
                                                    <select name="filter_audit_report_title"
                                                        id="filter_audit_report_title"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                        onchange="submitForm()">
                                                        <option value=""
                                                            {{ empty($selectedFilters['filter_audit_report_title']) ? 'selected' : '' }}>
                                                            All</option>
                                                        @foreach ($distinctReportTitles as $title)
                                                            <option value="{{ $title }}"
                                                                {{ isset($selectedFilters['filter_audit_report_title']) && $selectedFilters['filter_audit_report_title'] == $title ? 'selected' : '' }}>
                                                                {{ $title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="dropdown-container mb-4 lg:flex lg:justify-between">
                                                <div class="mb-4 lg:mb-0 lg:w-1/2 md:w-full sm:w-full lg:mr-4">
                                                    <label for="filter_status">Filter by Status:</label>
                                                    <select name="filter_status" id="filter_status"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                        onchange="submitForm()">
                                                        <option value=""
                                                            {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'all' ? 'selected' : '' }}>
                                                            All</option>
                                                        <option value="Fully Implemented"
                                                            {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'Fully Implemented' ? 'selected' : '' }}>
                                                            Show only Fully Implemented</option>
                                                        <option value="Not Implemented"
                                                            {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'Not Implemented' ? 'selected' : '' }}>
                                                            Show only Not Implemented</option>
                                                        <option value="No Update"
                                                            {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'noupdate' ? 'selected' : '' }}>
                                                            Show only No Update</option>
                                                        <option value="Partially Implemented"
                                                            {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'Partially Implemented' ? 'selected' : '' }}>
                                                            Show only Partially Implemented</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4 lg:mb-0 lg:w-1/2 md:w-full sm:w-full">
                                                    <label for="filter_recurrence" class="">Filter by
                                                        Repeated Findings:</label>
                                                    <select name="filter_recurrence" id="filter_recurrence"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                        onchange="submitForm()">
                                                        <option value=""
                                                            {{ empty($selectedFilters['filter_recurrence']) ? 'selected' : '' }}>
                                                            All</option>
                                                        <option value="No"
                                                            {{ isset($selectedFilters['filter_recurrence']) && $selectedFilters['filter_recurrence'] == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="Yes"
                                                            {{ isset($selectedFilters['filter_recurrence']) && $selectedFilters['filter_recurrence'] == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="dropdown-container lg:flex lg:justify-between">
                                                <div class="mb-4 lg:w-1/2 md:w-full sm:w-full lg:mr-4">
                                                    <label for="filter_audit_type" class="">Filter by Audit Type:</label>
                                                    <select name="filter_audit_type" id="filter_audit_type" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300" onchange="submitForm()">
                                                        <option value="all" {{ $filter_audit_type == 'all' ? 'selected' : '' }}>All</option>
                                                        <option value="Financial" {{ $filter_audit_type == 'Financial' ? 'selected' : '' }}>Financial</option>
                                                        <option value="Performance" {{ $filter_audit_type == 'Performance' ? 'selected' : '' }}>Performance</option>
                                                        <option value="Compliance" {{ $filter_audit_type == 'Compliance' ? 'selected' : '' }}>Compliance</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4 lg:w-1/2 md:w-full sm:w-full">
                                                    <label for="filter_client_types" class="">Filter by Client Type:</label>
                                                    <select name="filter_client_types" id="filter_client_types"
                                                            class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                            onchange="submitForm()">
                                                        <option value="" {{ empty($selectedFilters['filter_client_types']) ? 'selected' : '' }}>All</option>
                                                        @foreach ($distinctClientTypes as $clientType)
                                                            <option value="{{ $clientType->id }}"
                                                                    {{ isset($selectedFilters['filter_client_types']) && $selectedFilters['filter_client_types'] == $clientType->id ? 'selected' : '' }}>
                                                                {{ $clientType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="dropdown-container lg:flex lg:justify-between">
                                                <div class="mb-4 lg:w-1/2 md:w-full sm:w-full lg:mr-4">
                                                    <label for="filter_mainstream_gender" class="">Filter by Mainstream Gender:</label>
                                                    <select name="filter_mainstream_gender" id="filter_mainstream_gender"
                                                            class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                            onchange="submitForm()">
                                                        <option value="" {{ empty($selectedFilters['filter_mainstream_gender']) ? 'selected' : '' }}>All</option>
                                                        @foreach ($distinctMainstreamGenders as $gender)
                                                            <option value="{{ $gender->name }}"
                                                                    {{ isset($selectedFilters['filter_mainstream_gender']) && $selectedFilters['filter_mainstream_gender'] == $gender->name ? 'selected' : '' }}>
                                                                {{ $gender->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4 lg:w-1/2 md:w-full sm:w-full">
                                                    <label for="filter_risk_level" class="">Filter by Risk Level:</label>
                                                    <select name="filter_risk_level" id="filter_risk_level" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300" onchange="submitForm()">
                                                        <option value="all" {{ empty($selectedFilters['filter_risk_level']) ? 'selected' : '' }}>All</option>
                                                        <option value="Critical" {{ isset($selectedFilters['filter_risk_level']) && $selectedFilters['filter_risk_level'] == 'Critical' ? 'selected' : '' }}>Critical</option>
                                                        <option value="High" {{ isset($selectedFilters['filter_risk_level']) && $selectedFilters['filter_risk_level'] == 'High' ? 'selected' : '' }}>High</option>
                                                        <option value="Medium" {{ isset($selectedFilters['filter_risk_level']) && $selectedFilters['filter_risk_level'] == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                        <option value="Low" {{ isset($selectedFilters['filter_risk_level']) && $selectedFilters['filter_risk_level'] == 'Low' ? 'selected' : '' }}>Low</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="dropdown-container lg:flex lg:justify-between">
                                                <div class="mb-4 lg:w-1/2 md:w-full sm:w-full lg:mr-4">
                                                    <label for="filter_start_date" class="">Publication Date:</label>
                                                    <input type="date" name="filter_start_date"
                                                        id="filter_start_date"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                        onchange="submitDateRangeForm()"
                                                        value="{{ isset($selectedFilters['filter_start_date']) ? $selectedFilters['filter_start_date'] : '' }}">
                                                </div>
                                                <div class="mb-4 lg:w-1/2 md:w-full sm:w-full">
                                                    <label for="filter_end_date" class="">to</label>
                                                    <input type="date" name="filter_end_date" id="filter_end_date"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                        onchange="submitDateRangeForm()"
                                                        value="{{ isset($selectedFilters['filter_end_date']) ? $selectedFilters['filter_end_date'] : '' }}">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
