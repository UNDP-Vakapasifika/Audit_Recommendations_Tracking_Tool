<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Audit Recommendations Tracking Dashboard') }}</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @yield('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden min-h-screen">
            @include('partials.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    @yield('body')
                </div>
            </main>

            <footer class="bg-gray-300">
                <div class="container mx-auto px-6 py-4">
                    <div class="flex">
                        <div class="w-1/2">
                            <p class="text-sm text-gray-600">
                                &copy; {{now()->format('Y')}} United Nations Development Programme.
                            </p>
                        </div>
                        <div class="w-1/2 text-right">
                            <p class="text-sm text-gray-600">All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'success',
                toast: true,
                position: 'top-end',
                timer: 5000,
                showConfirmButton: false,
            });
        </script>

        @php Session::forget('success'); @endphp
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'error',
                text: '{{ session('error') }}',
                icon: 'error',
                toast: true,
                position: 'top-end',
                timer: 7000,
                showConfirmButton: false,
            });
        </script>
        @php session()->forget('error') @endphp
    @endif

    @if (session('errors'))
        <script>
            Swal.fire({
                title: 'error',
                text: 'Please check your inputs',
                icon: 'error',
                toast: true,
                position: 'top-end',
                timer: 6000,
                showConfirmButton: false,
            });
        </script>
        @php session()->forget('errors') @endphp
    @endif

    <script>
        $(document).ready(function() {
            $('.delete_item').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    
                    if (result.isConfirmed) {
                        //submit the from with the class delete_form
                        $(this).closest('form').submit();
                    }
                })
            });
        });
    </script>
    
    @yield('scripts')
</body>

</html>
