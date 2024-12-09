<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Audit Tracking Dashboard | Login') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    @php
        // Define the directory path
        $directory = public_path('img/logo');

        // Get all files from the directory
        $files = array_diff(scandir($directory), ['.', '..']);

        // Initialize variables for the latest file
        $latestFile = '';
        $latestTime = 0;

        // Check if there are any files
        if (!empty($files)) {
            // Loop through the files to find the latest one
            foreach ($files as $file) {
                $filePath = $directory . '/' . $file;
                if (is_file($filePath)) {
                    $fileTime = filemtime($filePath);
                    if ($fileTime > $latestTime) {
                        $latestTime = $fileTime;
                        $latestFile = $file;
                    }
                }
            }

            // Set the latest file path if found
            $backgroundImageUrl = asset('img/logo/' . $latestFile);
        } else {
            // Fallback to default image if no files are found
            $backgroundImageUrl = asset('img/undppp.jpg');
        }
    @endphp

    <div class="min-h-screen flex justify-center items-center pt-6 sm:pt-0"
        style="background-image: url('{{ $backgroundImageUrl }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        {{-- <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div> --}}

        <div class="w-full mx-4 sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
