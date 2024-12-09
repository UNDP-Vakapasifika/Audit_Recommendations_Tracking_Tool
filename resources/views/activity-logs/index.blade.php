<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h2 class="text-xl font-bold mb-4">Filter Logs by Date Range</h2>
                
                <form action="{{ route('activity-logs.index') }}" method="GET">
                    <div class="grid grid-cols-2 gap-4 w-3/4 mb-4">
                        <div class="flex">
                            <div class="col-span-1 flex-1">
                                <label for="start_date">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" class="w-3/4 bg-gray-100 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror" value="{{ $startDate }}" >
                            </div>
                            <div class="col-span-1 flex-1">
                                <label for="end_date">End Date:</label>
                                <input type="date" id="end_date" name="end_date" class="w-3/4 bg-gray-100 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('end_date') border-red-500 @enderror" value="{{ $endDate }}">
                            </div>
                            <div class="">
                                <x-primary-button type="submit">Apply Filter</x-primary-button>
                            </div>
                        </div>
                    </div>

                </form>

                <!-- <h2 class="text-xl font-bold mt-8 mb-4">Users with Logs</h2>
                <table class="w-full border border-gray-200">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">User Name</th>
                            <th class="border border-gray-200 px-4 py-2">Logs Start Date</th>
                            <th class="border border-gray-200 px-4 py-2">Logs End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usersWithLogs as $user)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2">
                                    <a href="{{ route('activity-logs.show', ['userId' => $user->id]) }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="border border-gray-200 px-4 py-2">{{ optional($user->activityLogs->first())->created_at }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ optional($user->activityLogs->last())->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> -->
            </div>
        </div>
    </div>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold mt-8 mb-4 text-center">Users with Logs</h2>
                <table class="w-full border border-gray-200">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 px-4 py-2">User Name</th>
                            <th class="border border-gray-200 px-4 py-2">Logs Start Date</th>
                            <th class="border border-gray-200 px-4 py-2">Logs End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usersWithLogs as $user)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2">
                                    <a href="{{ route('activity-logs.show', ['userId' => $user->id]) }}">
                                        <!-- {{ $user->name }} -->
                                        {{ optional($user->activityLogs->first())->name }}
                                    </a>
                                </td>
                                <td class="border border-gray-200 px-4 py-2">{{ optional($user->activityLogs->first())->created_at }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ optional($user->activityLogs->last())->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="home-footer mt-4 mx-auto">
        <p>&copy; <span id="currentYear">2023</span> United Nations Development Programme</p>
    </footer>
    
    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>

</x-app-layout>
