<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('The Final Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="notification-dropdown">
                        <!-- Display notifications here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="home-footer mt-4 mx-auto">
        <p>&copy; 2023 United Nations Development Programme</p>
    </footer>

    <!-- Include Laravel Echo and Pusher libraries -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Include your custom JavaScript file -->
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

</x-app-layout>
