<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('User Activity Logs in Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <p>User: {{ $user->name }}</p>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    
                    @if($logs->isEmpty())
                        <p>No logs found for the user.</p>
                    @else
                        <div>
                            @livewire('show-logs')
                        </div>
                        <!-- <div class="mb-4">
                            <label for="perPage" class="block text-sm font-medium text-gray-700">Rows per page:</label>
                            <select id="perPage" name="perPage" wire:model="perPage" class="w-3/4 mt-1 p-2 border rounded-md">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <table class="w-full border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Action</th>
                                    <th class="border border-gray-200 px-4 py-2">Description</th>
                                    <th class="border border-gray-200 px-4 py-2">IP Address</th>
                                    <th class="border border-gray-200 px-4 py-2">Date Created</th>
                                    <th class="border border-gray-200 px-4 py-2">Date Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        @if(is_array($log->activity))
                                            <td class="border border-gray-200 px-4 py-2">{{ $log->activity['type'] }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $log->activity['description'] }}</td>
                                        @else
                                            <td class="border border-gray-200 px-4 py-2">{{ $log->action}}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $log->activity}}</td>
                                        @endif
                                        <td class="border border-gray-200 px-4 py-2">{{ $log->ip_address }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $log->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table> -->

                        <!-- Display pagination links -->
                    @endif
                </div>
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
