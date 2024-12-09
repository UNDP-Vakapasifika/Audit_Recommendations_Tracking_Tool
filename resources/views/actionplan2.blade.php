<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Create The Action Plan') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('action-plans.store') }}" method="post">
                        @csr
                        <!-- Loop through each recommendation -->
                        @foreach($recommendations as $recommendation)

                                <div class="mb-4 flex space-x-4">
                                    <div class='flex-1'>
                                        <label for="recommendations[{{ $recommendation->id }}][action_plan]" class="block text-sm font-medium text-gray-600 ">
                                        recommendation 
                                        </label>
                                        <p> {{ $recommendation->recommendation }}</p>
                                    </div>
                                        
                                    <div class='flex-1'>
                                        <label for="recommendations[{{ $recommendation->id }}][action_plan]" class="block text-sm font-medium text-gray-600">
                                            Implementation Status
                                        </label>
                                        <p>- {{ $recommendation->implementation_status }}</p>
                                    </div>
                                    <div class='flex-1'>
                                        <label for="recommendations[{{ $recommendation->id }}][action_plan]" class="block text-sm font-medium text-gray-600">
                                        Action Plan
                                        </label>
                                        <input type="text" name="recommendations[{{ $recommendation->id }}][action_plan]" class="form-input mt-1 block flex-1" required>
                                    </div>
                                    <div class='flex-1'>
                                        <label for="recommendations[{{ $recommendation->id }}][completion_date]" class="block text-sm font-medium text-gray-600">
                                            Expected Date
                                        </label>
                                        <input type="date" name="recommendations[{{ $recommendation->id }}][completion_date]" class="form-input mt-1 block flex-1" required>
                                    </div>
                                </div>
                        @endforeach
                        <div class="text-center col-span-2">
                            <x-primary-button>
                                {{ __('Save') }}
                            </x-primary-button>
                            <x-primary-button class='ml-2'>
                                <a href="{{ route('action_plan1') }}" class="">Cancel</a>
                            </x-primary-button>
                        </div>
                    </form>

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
