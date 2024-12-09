<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/img/logo/' . $tool->logo) }}"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ $tool->tool_name }} Audit Recommendation Tracking Tool</title>

    <style>

        #dropdownMenu label:hover {
            background-color: #f1f1f1;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .nav-section {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* margin-top: 20px; */
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #F3F4F6;
            color: white;
        }

        tr {
            font-family: "Roboto", sans-serif;
            font-size: 30spx;
        }

        /* Styles for $navigation menu pop-up container */
        .nav-popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background overlay */
            z-index: 1000; /* Ensure $pop-up appears above other content */
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* Media queries for smaller screens */
        @media (max-width: 768px) {
            /* Reduce logo size on small screens */
            .logo {
                max-width: 80px;
                height: 60px;
            }

            /* Reduce title font size on small screens */
            .title {
                font-size: 1rem;
            }

            .top-section{
                width: 100%;
            }
        }

        .summary-section h4 {
            transition: ease-in-out 0.5s;
        }

        #dropdownMenuTitle {
            max-height: 190px; /* Adjust based on item height, 240px for 5 items */
            overflow-y: auto;
        }


    </style>
</head>

<body class="bg-gray-100 main-body">
        <nav class="fixed top-0 left-0 right-0 z-30">
            <!-- Navigation Bar Top Section -->
            <div class="homepage-nav-top flex justify-between items-center px-6 py-3">
                 @php
                    // Define the directory path for logo images
                    $directory = public_path('img/logo');
                    
                    // Get all files from the directory
                    $files = glob($directory . '/*'); // Get all files in the directory
                    
                    if ($files) {
                        // Find the most recently modified file
                        $latestFile = array_reduce($files, function ($carry, $item) {
                            return filemtime($carry) > filemtime($item) ? $carry : $item;
                        });
                    
                        // Use basename to get the filename from the path
                        $latestLogo = basename($latestFile);
                        $logoUrl = asset('img/logo/' . $latestLogo);
                    } else {
                        // Fallback to a default image if no files are found
                        $logoUrl = asset('img/undppp.jpg');
                    }
                @endphp
                <div class="navbar-left flex items-center lg:mr-4">
                    <img style="max-width: 150px; max-height: 90px;" class="w-auto h-auto object-contain" src="{{ $logoUrl }}" alt="Logo">
                </div>


                <div class="navbar-center flex-1 text-center">
                    <h1 class="title font-bold text-xl sm:text-l md:text-l dark:text-gray-800 uppercase">
                        {{ $tool->tool_name }} Audit Recommendations Tracking Tool
                    </h1>
                </div>
                <!-- Hamburger menu icon -->
                <div class="navbar-right ml-auto flex items-center">
                    <button id="menu-toggle" class="lg:hidden block text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                <!-- Navigation items -->
                <div id="nav-links" class="hidden lg:flex lg:items-center ml-auto pr-8">
                    <!-- Generate Report button -->
                    <form action="{{ route('parliament-report') }}" method="get" class="generate-pdf-form" target="_blank">
                        @csrf
                        <button class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md flex gap-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span>Legislature Report</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pop-up container -->
            <div id="nav-popup" class="nav-popup-container hidden">
                <!-- Close button -->
                <button id="close-btn" class="close-btn">&times;</button>
                <!-- Report button -->
                <form action="{{ route('parliament-report') }}" method="get" class="generate-pdf-form" target="_blank">
                    @csrf
                    <button class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md flex  gap-2 md:hidden lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span>Legislature Report</span>
                    </button>
                </form>
            </div>
        </nav>

    <div class="homepage-body mt-10">
        <section>
            <div class="containter">
                <div class="py-10 pt-[110px] top-section">
                    <div class="mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="bg-white border border-gray-200 p-4">
                                <!-- Charts Section -->
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

                                <!-- Summary Section -->
                                <div class="summary-section flex flex-wrap justify-around text-center mb-4">
                                    <!-- Clients -->
                                    <div class="relative w-full px-2 sm:w-1/2 xl:w-1/4 mb-4">
                                        <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                                                <!-- SVG Icon for Clients -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M10 21V10m4 11V10M7 21V6.5A1.5 1.5 0 0 1 8.5 5h7A1.5 1.5 0 0 1 17 6.5V21m-7-5h4" />
                                                </svg>
                                            </div>
                                            <div class="mx-5">
                                                <h4 x-data="{ count: 0 }" x-init="let target = {{ $totalLeadBodies }};
                                                            let increment = target / 50;
                                                            let interval = setInterval(() => {
                                                                if (count < target) {
                                                                    count += increment;
                                                                } else {
                                                                    count = target;
                                                                    clearInterval(interval);
                                                                }
                                                            }, 50);" x-text="Math.ceil(count)" class="text-2xl font-semibold text-gray-700"></h4>
                                                <div class="text-gray-500">Clients</div>
                                            </div>
                                        </div>
                                        <span class="absolute top-0 right-0 -mt-2 -mr-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                            New +{{ $recentLeadBodies }}
                                        </span>
                                    </div>

                                    <!-- Audits -->
                                    <div class="relative w-full px-2 sm:w-1/2 xl:w-1/4 mb-4">
                                        <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                                            <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                                                <!-- SVG Icon for Audits -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M9 17A7.5 7.5 0 1 1 16.5 9 7.5 7.5 0 0 1 9 17z" />
                                                </svg>
                                            </div>
                                            <div class="mx-5">
                                                <h4 x-data="{ count: 0 }" x-init="let target = {{ $totalReportTitles }};
                                                            let increment = target / 50;
                                                            let interval = setInterval(() => {
                                                                if (count < target) {
                                                                    count += increment;
                                                                } else {
                                                                    count = target;
                                                                    clearInterval(interval);
                                                                }
                                                            }, 50);" x-text="Math.ceil(count)" class="text-2xl font-semibold text-gray-700"></h4>
                                                <div class="text-gray-500">Audits</div>
                                            </div>
                                        </div>
                                        <span class="absolute top-0 right-0 -mt-2 -mr-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                        New +{{ $recentReportTitles }}
                                        </span>
                                    </div>

                                    <!-- Recommendations -->
                                    <div class="relative w-full px-2 sm:w-1/2 xl:w-1/4 mb-4">
                                        <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                                                <!-- SVG Icon for Recommendations -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V3m0 0C9.8 3 8 4.8 8 7m4-4c2.2 0 4 1.8 4 4m-4-4h7.5m-3.5 7V7m0 0h-1.5m0 0v10.5m0 0h-1.5m0 0h3m0 0v1.5m0 0h1.5m-7.5 0h-7m2 0h3m-4.5 0v1.5M9 17.25V16m0 0h1.5m0 0v-7.5m-1.5 0H7.5m0 0h-1.5m3 0H15m-7.5 0V9m0 0h1.5" />
                                                </svg>
                                            </div>
                                            <div class="mx-5">
                                                <h4 x-data="{ count: 0 }" x-init="let target = {{ $totalRecommendationsCount }};
                                                            let increment = target / 50;
                                                            let interval = setInterval(() => {
                                                                if (count < target) {
                                                                    count += increment;
                                                                } else {
                                                                    count = target;
                                                                    clearInterval(interval);
                                                                }
                                                            }, 50);" x-text="Math.ceil(count)" class="text-2xl font-semibold text-blue-700"></h4>
                                                <div class="text-gray-500">Recommendations</div>
                                            </div>
                                        </div>
                                        <span class="absolute top-0 right-0 -mt-2 -mr-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                        New +{{ $recentRecommendationsCount }}
                                        </span>
                                    </div>

                                    <!-- Repeated -->
                                    <div class="relative w-full px-2 sm:w-1/2 xl:w-1/4 mb-4">
                                        <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                                            <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                                                <!-- SVG Icon for Repeated -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l6 6m-6-6l6-6M6 6h.01M6 18h.01M18 18h.01M18 6h.01M21.75 12A9.75 9.75 0 1 1 12 2.25 9.75 9.75 0 0 1 21.75 12z" />
                                                </svg>
                                            </div>
                                            <div class="mx-5">
                                                <h4 x-data="{ count: 0 }" x-init="let target = {{ $totalRecurrence }};
                                                            let increment = target / 50;
                                                            let interval = setInterval(() => {
                                                                if (count < target) {
                                                                    count += increment;
                                                                } else {
                                                                    count = target;
                                                                    clearInterval(interval);
                                                                }
                                                            }, 50);" x-text="Math.ceil(count)" class="text-2xl font-semibold text-blue-700"></h4>
                                                <div class="text-gray-500">Repeated</div>
                                            </div>
                                        </div>
                                        <span class="absolute top-0 right-0 -mt-2 -mr-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                        New  +{{ $recentRecurrence }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="border-blue-600 mb-2">
                                <!-- Filters Section -->
                                <div class="flex justify-between items-center col-span-2 mb-4">
                                    <h1 class="font-bold text-xl text-blue-800 leading-tight">Filter Section</h1>
                                    <button type="button" onclick="clearFilters()"
                                        class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-2 px-4 rounded-lg lg:h-10 sm:h-20 md:h-10">
                                        Clear Filters
                                    </button>
                                </div>

                                <div class="filter-section flex flex-wrap justify-around mb-4">
                                    <form method="get" action="{{ route('home2') }}" class="my-form filter-form flex flex-wrap gap-4 w-full">
                                        @csrf

                                        <div class="filter-item">
                                            <label for="filter_mainstream_gender" class="">Filter by Mainstream Gender:</label>
                                            <div class="relative">
                                                <div>
                                                    <button type="button" id="dropdownButton"
                                                            class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        <span id="selectedLabel">Choose..</span>
                                                    </button>
                                                </div>
                                                <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_mainstream_gender[]" value=""
                                                                class="mr-2" id="selectAll" {{ empty($selectedFilters['filter_mainstream_gender']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            All
                                                        </label>
                                                        @foreach ($distinctMainstreamGenders as $gender)
                                                            <label class="flex items-center">
                                                                <input type="checkbox" name="filter_mainstream_gender[]" value="{{ $gender->name }}"
                                                                    class="mr-2"
                                                                    {{ isset($selectedFilters['filter_mainstream_gender']) && in_array($gender->name, $selectedFilters['filter_mainstream_gender']) ? 'checked' : '' }}
                                                                    onchange="submitForm()">
                                                                {{ $gender->name }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filter-item">
                                            <label for="filter_audit_report_title" class="">Filter by Report Title:</label>
                                            <div class="relative">
                                                <div>
                                                    <button type="button" id="dropdownButtonTitle"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        <span id="selectedLabelTitle">Select Report Title..</span>
                                                    </button>
                                                </div>
                                                <div id="dropdownMenuTitle" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden overflow-y-auto max-h-60">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButtonTitle">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_audit_report_title[]" value=""
                                                                class="mr-2" id="selectAllTitle" {{ empty($selectedFilters['filter_audit_report_title']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            All
                                                        </label>
                                                        @foreach ($distinctReportTitles as $title)
                                                            <label class="flex items-center">
                                                                <input type="checkbox" name="filter_audit_report_title[]" value="{{ $title }}"
                                                                    class="mr-2"
                                                                    {{ isset($selectedFilters['filter_audit_report_title']) && in_array($title, $selectedFilters['filter_audit_report_title']) ? 'checked' : '' }}
                                                                    onchange="submitForm()">
                                                                {{ $title }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filter-item">
                                            <label for="filter_status">Filter by Implementation Status:</label>
                                            <div class="relative">
                                                <div>
                                                    <button type="button" id="dropdownButtonStatus"
                                                            class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        <span id="selectedLabelStatus">Choose..</span>
                                                    </button>
                                                </div>
                                                <div id="dropdownMenuStatus" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden overflow-y-auto max-h-60">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButtonStatus">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_status[]" value="" 
                                                                class="mr-2" id="selectAllStatus" {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'all' ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            All
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_status[]" value="Fully Implemented"
                                                                class="mr-2" 
                                                                {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'Fully Implemented' ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Fully Implemented
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_status[]" value="Not Implemented"
                                                                class="mr-2" 
                                                                {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'Not Implemented' ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Not Implemented
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_status[]" value="No Update"
                                                                class="mr-2" 
                                                                {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'No Update' ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            No Update
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_status[]" value="Partially Implemented"
                                                                class="mr-2" 
                                                                {{ isset($selectedFilters['filter_status']) && $selectedFilters['filter_status'] == 'Partially Implemented' ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Partially Implemented
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filter-item">
                                            <label for="filter_recurrence" class="">Filter by Repeated Findings:</label>
                                            <div class="relative">
                                                <div>
                                                    <button type="button" id="dropdownButtonRecurrence"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        <span id="selectedLabelRecurrence">Select Recurrence..</span>
                                                    </button>
                                                </div>
                                                <div id="dropdownMenuRecurrence" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden overflow-y-auto max-h-60">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButtonRecurrence">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_recurrence[]" value=""
                                                                class="mr-2" id="selectAllRecurrence" {{ empty($selectedFilters['filter_recurrence']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            All
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_recurrence[]" value="No"
                                                                class="mr-2"
                                                                {{ isset($selectedFilters['filter_recurrence']) && in_array('No', $selectedFilters['filter_recurrence']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            No
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_recurrence[]" value="Yes"
                                                                class="mr-2"
                                                                {{ isset($selectedFilters['filter_recurrence']) && in_array('Yes', $selectedFilters['filter_recurrence']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Yes
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filter-item">
                                            <label for="filter_audit_type" class="">Filter by Audit Type:</label>
                                            <div class="relative">
                                                <div>
                                                    <button type="button" id="dropdownButtonAuditType"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        <span id="selectedLabelAuditType">Select Audit Type..</span>
                                                    </button>
                                                </div>
                                                <div id="dropdownMenuAuditType" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden overflow-y-auto max-h-60">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButtonAuditType">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_audit_type[]" value=""
                                                                class="mr-2" id="selectAllAuditType" {{ empty($selectedFilters['filter_audit_type']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            All
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_audit_type[]" value="Financial"
                                                                class="mr-2"
                                                                {{ isset($selectedFilters['filter_audit_type']) && in_array('Financial', $selectedFilters['filter_audit_type']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Financial
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_audit_type[]" value="Performance"
                                                                class="mr-2"
                                                                {{ isset($selectedFilters['filter_audit_type']) && in_array('Performance', $selectedFilters['filter_audit_type']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Performance
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_audit_type[]" value="Compliance"
                                                                class="mr-2"
                                                                {{ isset($selectedFilters['filter_audit_type']) && in_array('Compliance', $selectedFilters['filter_audit_type']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            Compliance
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filter-item">
                                            <label for="filter_client_types" class="">Filter by Client Type:</label>
                                            <div class="relative">
                                                <div>
                                                    <button type="button" id="dropdownButtonClientTypes"
                                                        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        <span id="selectedLabelClientTypes">Select Client Type..</span>
                                                    </button>
                                                </div>
                                                <div id="dropdownMenuClientTypes" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden overflow-y-auto max-h-60">
                                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButtonClientTypes">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="filter_client_types[]" value=""
                                                                class="mr-2" id="selectAllClientTypes" {{ empty($selectedFilters['filter_client_types']) ? 'checked' : '' }}
                                                                onchange="submitForm()">
                                                            All
                                                        </label>
                                                        @foreach ($distinctClientTypes as $clientType)
                                                            <label class="flex items-center">
                                                                <input type="checkbox" name="filter_client_types[]" value="{{ $clientType->id }}"
                                                                    class="mr-2"
                                                                    {{ isset($selectedFilters['filter_client_types']) && in_array($clientType->id, $selectedFilters['filter_client_types']) ? 'checked' : '' }}
                                                                    onchange="submitForm()">
                                                                {{ $clientType->name }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="filter-item">
                                            <label for="filter_start_date" class="">From Publication Date:</label>
                                            <input type="date" name="filter_start_date"
                                                id="filter_start_date"
                                                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                onchange="submitDateRangeForm()"
                                                value="{{ isset($selectedFilters['filter_start_date']) ? $selectedFilters['filter_start_date'] : '' }}">
                                        </div>

                                        
                                        <div class="filter-item">
                                            <label for="filter_end_date" class="">To Publication Date:</label>
                                            <input type="date" name="filter_end_date" id="filter_end_date"
                                                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:border-blue-300"
                                                onchange="submitDateRangeForm()"
                                                value="{{ isset($selectedFilters['filter_end_date']) ? $selectedFilters['filter_end_date'] : '' }}">
                                        </div>
                                    </form>
                                </div>
                                <hr class="border-blue-600">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table contents -->
                <div class=" mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="overflow-x-auto max-w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <!-- Move $download button here -->
                                    <h1></h1>
                                    <button id="download-btn"
                                        class="bg-blue-600 hover:bg-[#0027C6] text-white font-bold py-2 px-4 rounded lg:h-10 sm:h-10 md:h-10">Download
                                        CSV</button>
                                </div>
                                <!-- <button id="download-btn" class="bg-blue-500 hover:bg-blue-700 mb-2 text-white font-bold py-2 px-4 rounded lg:h-10 sm:h-20 md:h-20 ml-auto">Download CSV Report</button> -->
                                <table class="w-full border border-gray-200 table-auto min-w-full" id="example"
                                    style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th class="border text-black border-gray-200 px-4 py-2">Client
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Client Type
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Audit Report
                                                Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Publication Date
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Page Par Reference
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Audit
                                                Recommendations
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Implementation
                                                Status</th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Mainstream Category</th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Key
                                                Issues&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Risk Level
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Acceptance Status
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Target Completion
                                                Date
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Follow Up Date</th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Repeated Findings
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Reason Not Fully Implemented
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                            <th class="border text-black border-gray-200 px-4 py-2">Audited Entity
                                                Summary of
                                                Response&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filteredRecommendations as $finalReport)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['client_name'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['client_type_name'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2 wrap-content">
                                                    {{ $finalReport['audit_report_title'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['publication_date']->format('d, M Y') }}
                                                    </td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['page_par_reference'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2 wrap-content">
                                                    {{ $finalReport['audit_recommendations'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['current_implementation_status'] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $finalReport->mainstreamCategory->name ?? 'Not specified' }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2 wrap-content">
                                                    {{ $finalReport['key_issues'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                {{ $finalReport['classification'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['acceptance_status'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['target_completion_date']->format('d, M Y') }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2">
                                                    {{ $finalReport['follow_up_date']->format('d, M Y') }}</td>
                                                <td class="border border-gray-200 text-gray-500 px-4 py-2">
                                                    {{ $finalReport['recurence'] }}</td>
                                                <td class="border border-gray-200 text-gray-500 px-4 py-2">
                                                    {{ $finalReport['reason_not_implemented'] }}</td>
                                                <td class="border border-gray-200 text-gray-600 px-4 py-2 wrap-content">
                                                    {{ $finalReport['summary_of_response'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <button onclick="topFunction()" id="backToTopBtn" class="" title="Go to top">&#8593; Top</button>

    <footer class="bg-[#0027C6]">
        <div class="w-full py-4 text-white sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <a href="https://european-union.europa.eu/index_en"
                    class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('img/European_Commission.svg') }}" class="h-10" alt="EU logo" />
                    <span class="self-center text-2l font-semibold whitespace-nowrap dark:text-white">European
                        Union</span>
                </a>
                <p class="self-center hidden md:block text-2l font-semibold whitespace-nowrap text-white">&copy; <span
                        id="currentYear">2023</span> All Rights Reserved</p>
                <a href="https://www.undp.org/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('img/undp-logo.png') }}" class="h-10" alt="UNDP logo" />
                    <span class="self-center text-2l font-semibold whitespace-nowrap dark:text-white">UNDP</span>
                </a>
            </div>
            <p class="text-center md:hidden text-2l font-semibold whitespace-nowrap text-white">&copy; <span
                    id="currentYear">2023</span> All Rights Reserved</p>
        </div>
    </footer>

    <script>
        // When $user scrolls down 20px from $top of $document, show $button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("backToTopBtn").style.display = "block";
            } else {
                document.getElementById("backToTopBtn").style.display = "none";
            }
        }

        // When $user clicks on $button, scroll to $top of $document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>

    <!-- Chart JavaScript Section -->
    <script>
        // Create $data object for Chart 1 (Fully Implemented)
        var dataFullyImplemented = {
            labels: [],
            datasets: [{
                data: [{{ $percent_fully_implemented }}, {{ 100 - $percent_fully_implemented }}],
                backgroundColor: [
                    "#6eae40",
                    "#CCCCCC"
                ],
                hoverBackgroundColor: []
            }]
        };

        // Create $chart for Chart 1
        var promisedDeliveryChart1 = new Chart(document.getElementById('myChart1'), {
            type: 'doughnut',
            data: dataFullyImplemented,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    drawCenterText: {
                        display: true,
                        text: '{{ round($percent_fully_implemented) }}%'
                    }
                },
                title: {
                    display: true,
                    text: 'Fully Implemented',
                    fontSize: 18,
                    fontColor: 'black'
                }
            },
            plugins: [{
                id: 'drawCenterText',
                beforeDraw: function(chart, args, options) {
                    if (options.display) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";

                        var text = options.text,
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 1.6;

                        ctx.fillStyle = '#6eae40';
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            }]
        });

        // Create $data object for Chart 2 (Partially Implemented)
        var dataPartially = {
            labels: [],
            datasets: [{
                data: [{{ $percent_partially }}, {{ 100 - $percent_partially }}],
                backgroundColor: [
                    "#4270c7",
                    "#CCCCCC"
                ],
                hoverBackgroundColor: []
            }]
        };

        // Create $chart for Chart 2
        var promisedDeliveryChart2 = new Chart(document.getElementById('myChart2'), {
            type: 'doughnut',
            data: dataPartially,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    drawCenterText: {
                        display: true,
                        text: '{{ round($percent_partially) }}%'
                    }
                },
                title: {
                    display: true,
                    text: 'Partially Implemented',
                    fontSize: 18,
                    fontColor: 'black'
                }
            },
            plugins: [{
                id: 'drawCenterText',
                beforeDraw: function(chart, args, options) {
                    if (options.display) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";

                        var text = options.text,
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 1.6;

                        ctx.fillStyle = '#4270c7';
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            }]
        });

        // Create $data object for Chart 3 (noupdate)
        var datanoupdate = {
            labels: [],
            datasets: [{
                data: [{{ $percent_noupdate }}, {{ 100 - $percent_noupdate }}],
                backgroundColor: [
                    "#ffc100",
                    "#CCCCCC"
                ],
                hoverBackgroundColor: []
            }]
        };

        // Create $chart for Chart 3
        var promisedDeliveryChart3 = new Chart(document.getElementById('myChart3'), {
            type: 'doughnut',
            data: datanoupdate,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    drawCenterText: {
                        display: true,
                        text: '{{ round($percent_noupdate) }}%'
                    }
                },
                title: {
                    display: true,
                    text: 'No Update',
                    fontSize: 18,
                    fontColor: 'black'
                }
            },
            plugins: [{
                id: 'drawCenterText',
                beforeDraw: function(chart, args, options) {
                    if (options.display) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";

                        var text = options.text,
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 1.6;

                        ctx.fillStyle = '#ffc100';
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            }]
        });

        // Create $data object for Chart 4 (Not Implemented)
        var dataNot = {
            labels: [],
            datasets: [{
                data: [{{ $percent_not }}, {{ 100 - $percent_not }}],
                backgroundColor: [
                    "#ff0000",
                    "#CCCCCC"
                ],
                hoverBackgroundColor: []
            }]
        };

        // Create $chart for Chart 4
        var promisedDeliveryChart4 = new Chart(document.getElementById('myChart4'), {
            type: 'doughnut',
            data: dataNot,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    drawCenterText: {
                        display: true,
                        text: '{{ round($percent_not) }}%'
                    }
                },
                title: {
                    display: true,
                    text: 'Not Implemented',
                    fontSize: 18,
                    fontColor: 'black'
                }
            },
            plugins: [{
                id: 'drawCenterText',
                beforeDraw: function(chart, args, options) {
                    if (options.display) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;

                        ctx.restore();
                        var fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";

                        var text = options.text,
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 1.6;

                        ctx.fillStyle = '#ff0000';
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            }]
        });
    </script>

    <!-- JavaScript code for downloading CSV -->
    <script>
        const downloadBtn = document.getElementById('download-btn');
        downloadBtn.addEventListener('click', () => {
            // Get table data as an array of arrays
            const table = document.querySelector('table');
            const rows = Array.from(table.querySelectorAll('tr'));
            const data = rows.map(row => Array.from(row.querySelectorAll('td')).map(td => td.innerText));

            // Get table header row as an array
            const headerRow = Array.from(table.querySelectorAll('thead tr th')).map(th => th.innerText);
            data.unshift(headerRow);

            // Create CSV file
            const csv = data.map(row => row.join(',')).join('\n');
            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = URL.createObjectURL(blob);

            // Download CSV file
            const a = document.createElement('a');
            a.href = url;
            a.download = 'recommendations.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#download-btn2').on('click', function(e) {
                // Show $PDF preview iframe...
                $('#preview-pdf').show();

                // Delay to allow $iframe to be rendered before loadin.
                setTimeout(function() {
                    // Submit $form to generate $PDF in a new tab...
                    $('form.generate-pdf-form').submit();
                }, 1000);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var selectElement = document.getElementById("filter_status");
            selectElement.addEventListener("change", function() {
                var options = selectElement.options;
                for (var i = 0; i < options.length; i++) {
                    if (options[i].selected) {
                        options[i].textContent = options[i].textContent + " ✓";
                    } else {
                        options[i].textContent = options[i].textContent.replace(" ✓", "");
                    }
                }
            });
        });
    </script>

    <script>
        function submitForm() {
            document.querySelector('.filter-form').submit();
        }

        function clearFilters() {
            window.location.href = "{{ route('home') }}";
        }
    </script>

    <script>
        function updateEndDateRange() {
            // Get $selected start date
            let startDate = document.getElementById('filter_start_date').value;
            // Set $minimum date for $end date input field
            document.getElementById('filter_end_date').min = startDate;
        }
    </script>

    </div>

    <script>
        const reloadInterval = 60000; // 60 seconds

        // Function to reload $page
        function reloadPage() {
            location.reload();
        }

        let reloadTimeout;

        function resetReloadTimer() {
            clearTimeout(reloadTimeout);

            reloadTimeout = setTimeout(reloadPage, reloadInterval);
        }

        document.addEventListener('mousemove', resetReloadTimer);
        document.addEventListener('keypress', resetReloadTimer);

        resetReloadTimer();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const checkboxes = dropdownMenu.querySelectorAll('input[type="checkbox"]');
            const selectAllCheckbox = document.getElementById('selectAll');
            const selectedLabel = document.getElementById('selectedLabel');
            let isFormChanged = false; // Flag to track form changes

            // Toggle the dropdown menu visibility
            dropdownButton.addEventListener('click', (event) => {
                // Prevent form submission when clicking the button
                event.preventDefault();
                dropdownMenu.classList.toggle('hidden');
            });

            // Handle the "All" checkbox logic
            selectAllCheckbox.addEventListener('change', () => {
                if (selectAllCheckbox.checked) {
                    checkboxes.forEach(cb => {
                        if (cb !== selectAllCheckbox) cb.checked = false;
                    });
                    isFormChanged = true;
                } else {
                    // Uncheck "All" should not affect individual checkboxes
                    isFormChanged = true;
                }
                updateLabel();
            });

            // Uncheck "All" if another checkbox is selected
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox !== selectAllCheckbox && checkbox.checked) {
                        selectAllCheckbox.checked = false;
                    }
                    isFormChanged = true;
                    updateLabel();
                });
            });

            // Function to update the dropdown label
            function updateLabel() {
                const checkedItems = Array.from(checkboxes).filter(cb => cb.checked && cb !== selectAllCheckbox);
                const checkedCount = checkedItems.length;

                if (checkedCount > 0) {
                    selectedLabel.textContent = `Filters Applied(${checkedCount})`;
                } else {
                    selectedLabel.textContent = 'Select Mainstream Type..';
                }
            }

            // Initial label update in case of pre-checked options
            updateLabel();

            // Function to submit the form if there are changes
            function submitForm() {
                if (isFormChanged) {
                    document.querySelector('.filter-form').submit();
                    isFormChanged = false; // Reset flag after submission
                }
            }

            // Attach the form submission to change events
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', submitForm);
            });

            selectAllCheckbox.addEventListener('change', submitForm);
        });
    </script>



    <Script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButtonTitle = document.getElementById('dropdownButtonTitle');
            const dropdownMenuTitle = document.getElementById('dropdownMenuTitle');
            const checkboxesTitle = dropdownMenuTitle.querySelectorAll('input[type="checkbox"]');
            const selectAllCheckboxTitle = document.getElementById('selectAllTitle');
            const selectedLabelTitle = document.getElementById('selectedLabelTitle');

            // Toggle the dropdown menu visibility
            dropdownButtonTitle.addEventListener('click', () => {
                dropdownMenuTitle.classList.toggle('hidden');
            });

            // Handle the "All" checkbox logic
            selectAllCheckboxTitle.addEventListener('change', () => {
                if (selectAllCheckboxTitle.checked) {
                    checkboxesTitle.forEach(cb => {
                        if (cb !== selectAllCheckboxTitle) cb.checked = false;
                    });
                    updateLabelTitle();
                }
            });

            // Uncheck "All" if another checkbox is selected
            checkboxesTitle.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox !== selectAllCheckboxTitle && checkbox.checked) {
                        selectAllCheckboxTitle.checked = false;
                    }
                    updateLabelTitle();
                });
            });

            // Function to update the dropdown label
            function updateLabelTitle() {
                const checkedItemsTitle = Array.from(checkboxesTitle).filter(cb => cb.checked && cb !== selectAllCheckboxTitle);
                const checkedCountTitle = checkedItemsTitle.length;

                if (checkedCountTitle > 0) {
                    selectedLabelTitle.textContent = `Filters Applied(${checkedCountTitle})`;
                } else {
                    selectedLabelTitle.textContent = 'Select Report Title..';
                }
            }

            // Initial label update in case of pre-checked options
            updateLabelTitle();
        });

        // Function to submit the form
        function submitForm() {
            document.querySelector('.filter-form').submit();
        }
    </Script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Filter by Report Title

            // Filter by Repeated Findings
            const dropdownButtonRecurrence = document.getElementById('dropdownButtonRecurrence');
            const dropdownMenuRecurrence = document.getElementById('dropdownMenuRecurrence');
            const selectAllRecurrence = document.getElementById('selectAllRecurrence');
            const selectedLabelRecurrence = document.getElementById('selectedLabelRecurrence');

            dropdownButtonRecurrence.addEventListener('click', () => {
                dropdownMenuRecurrence.classList.toggle('hidden');
            });

            selectAllRecurrence.addEventListener('change', function() {
                const checkboxes = dropdownMenuRecurrence.querySelectorAll('input[type="checkbox"]:not(#selectAllRecurrence)');
                checkboxes.forEach(checkbox => checkbox.checked = false);
                updateSelectedLabel(selectedLabelRecurrence, selectAllRecurrence);
            });

            dropdownMenuRecurrence.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox' && e.target !== selectAllRecurrence) {
                    selectAllRecurrence.checked = false;
                    updateSelectedLabel(selectedLabelRecurrence, selectAllRecurrence);
                }
            });

            // Filter by Audit Type
            const dropdownButtonAuditType = document.getElementById('dropdownButtonAuditType');
            const dropdownMenuAuditType = document.getElementById('dropdownMenuAuditType');
            const selectAllAuditType = document.getElementById('selectAllAuditType');
            const selectedLabelAuditType = document.getElementById('selectedLabelAuditType');

            dropdownButtonAuditType.addEventListener('click', () => {
                dropdownMenuAuditType.classList.toggle('hidden');
            });

            selectAllAuditType.addEventListener('change', function() {
                const checkboxes = dropdownMenuAuditType.querySelectorAll('input[type="checkbox"]:not(#selectAllAuditType)');
                checkboxes.forEach(checkbox => checkbox.checked = false);
                updateSelectedLabel(selectedLabelAuditType, selectAllAuditType);
            });

            dropdownMenuAuditType.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox' && e.target !== selectAllAuditType) {
                    selectAllAuditType.checked = false;
                    updateSelectedLabel(selectedLabelAuditType, selectAllAuditType);
                }
            });

            // Filter by Client Types
            const dropdownButtonClientTypes = document.getElementById('dropdownButtonClientTypes');
            const dropdownMenuClientTypes = document.getElementById('dropdownMenuClientTypes');
            const selectAllClientTypes = document.getElementById('selectAllClientTypes');
            const selectedLabelClientTypes = document.getElementById('selectedLabelClientTypes');

            dropdownButtonClientTypes.addEventListener('click', () => {
                dropdownMenuClientTypes.classList.toggle('hidden');
            });

            selectAllClientTypes.addEventListener('change', function() {
                const checkboxes = dropdownMenuClientTypes.querySelectorAll('input[type="checkbox"]:not(#selectAllClientTypes)');
                checkboxes.forEach(checkbox => checkbox.checked = false);
                updateSelectedLabel(selectedLabelClientTypes, selectAllClientTypes);
            });

            dropdownMenuClientTypes.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox' && e.target !== selectAllClientTypes) {
                    selectAllClientTypes.checked = false;
                    updateSelectedLabel(selectedLabelClientTypes, selectAllClientTypes);
                }
            });

            // Filter by Country Office
            const dropdownButtonCountryOffice = document.getElementById('dropdownButtonCountryOffice');
            const dropdownMenuCountryOffice = document.getElementById('dropdownMenuCountryOffice');
            const selectAllCountryOffice = document.getElementById('selectAllCountryOffice');
            const selectedLabelCountryOffice = document.getElementById('selectedLabelCountryOffice');

            dropdownButtonCountryOffice.addEventListener('click', () => {
                dropdownMenuCountryOffice.classList.toggle('hidden');
            });

            selectAllCountryOffice.addEventListener('change', function() {
                const checkboxes = dropdownMenuCountryOffice.querySelectorAll('input[type="checkbox"]:not(#selectAllCountryOffice)');
                checkboxes.forEach(checkbox => checkbox.checked = false);
                updateSelectedLabel(selectedLabelCountryOffice, selectAllCountryOffice);
            });

            dropdownMenuCountryOffice.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox' && e.target !== selectAllCountryOffice) {
                    selectAllCountryOffice.checked = false;
                    updateSelectedLabel(selectedLabelCountryOffice, selectAllCountryOffice);
                }
            });

            function updateSelectedLabel(labelElement, selectAllElement) {
                const selectedCheckboxes = labelElement.closest('div.relative').querySelectorAll('input[type="checkbox"]:checked:not(#' + selectAllElement.id + ')');
                if (selectedCheckboxes.length === 0 || selectAllElement.checked) {
                    labelElement.textContent = 'Select..';
                } else {
                    const selectedTexts = Array.from(selectedCheckboxes).map(cb => cb.closest('label').textContent.trim());
                    labelElement.textContent = selectedTexts.join(', ');
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdownButtonStatus = document.getElementById('dropdownButtonStatus');
            const dropdownMenuStatus = document.getElementById('dropdownMenuStatus');
            const checkboxesStatus = dropdownMenuStatus.querySelectorAll('input[type="checkbox"]');
            const selectAllCheckboxStatus = document.getElementById('selectAllStatus');
            const selectedLabelStatus = document.getElementById('selectedLabelStatus');

            // Toggle the dropdown menu visibility
            dropdownButtonStatus.addEventListener('click', () => {
                dropdownMenuStatus.classList.toggle('hidden');
            });

            // Handle the "All" checkbox logic
            selectAllCheckboxStatus.addEventListener('change', () => {
                if (selectAllCheckboxStatus.checked) {
                    checkboxesStatus.forEach(cb => {
                        if (cb !== selectAllCheckboxStatus) cb.checked = false;
                    });
                    updateLabel();
                }
            });

            // Uncheck "All" if another checkbox is selected
            checkboxesStatus.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox !== selectAllCheckboxStatus && checkbox.checked) {
                        selectAllCheckboxStatus.checked = false;
                    }
                    updateLabel();
                });
            });

            // Function to update the dropdown label
            function updateLabel() {
                const checkedItems = Array.from(checkboxesStatus).filter(cb => cb.checked && cb !== selectAllCheckboxStatus);
                const checkedCount = checkedItems.length;

                if (checkedCount > 0) {
                    selectedLabelStatus.textContent = `Filters Applied(${checkedCount})`;
                } else {
                    selectedLabelStatus.textContent = 'Choose Status';
                }
            }

            // Initial label update in case of pre-checked options
            updateLabel();
        });

        // Function to submit the form
        function submitForm() {
            document.querySelector('.filter-form').submit();
        }

    </script>

    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({});
        });

    </script>

    <script>
        // JavaScript to toggle $visibility of $navigation menu pop-up
        const menuToggle = document.getElementById('menu-toggle');
        const navPopup = document.getElementById('nav-popup');
        const closeBtn = document.getElementById('close-btn');

        menuToggle.addEventListener('click', function() {
            navPopup.style.display = 'block';
        });

        closeBtn.addEventListener('click', function() {
            navPopup.style.display = 'none';
        });
    </script>

    <script>
        // Function to submit $date range form
        function submitDateRangeForm() {
            const startDateInput = document.getElementById('filter_start_date');
            const endDateInput = document.getElementById('filter_end_date');

            // Check if both dates have been selected
            if (startDateInput.value && endDateInput.value) {
                // Submit $form
                startDateInput.closest('form').submit();
            }
        }
    </script>

</body>

</html>
