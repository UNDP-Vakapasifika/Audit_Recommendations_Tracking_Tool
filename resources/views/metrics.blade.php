<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Final Report Metrics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- {{ __("Add metrics here") }} -->
                    <div class="container">
                        <!-- <div>
                            <h1 class="card-h1">Metrics</h1>
                        </div> -->

                        <!-- <div class="table-filter">
                            <form action="{{ route('modify') }}" method="post">
                                @csrf

                                <div class="flex flex-wrap justify-between">
                                    <div class="w-1/3">
                                        <x-input-label for="column_title" :value="__('Select Column Title:')" />
                                        <select id="column_title" name="column_title">
                                            @foreach ($descriptions as $description)
                                                <option value="{{ $description['column_title'] }}">{{ $description['column_title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-1/3">
                                        <x-input-label for="new_column" :value="__('New Column Title:')" />
                                        <x-text-input id="new_column" class="block mt-1" type="text" name="new_column" :value="old('new_column')" required autofocus autocomplete="new_column" />
                                        <x-input-error :messages="$errors->get('new_column')" class="mt-2" />
                                    </div>
                                    <div class="w-1/3">
                                        <x-input-label for="description" :value="__('Description:')" />
                                        <x-text-input id="description" class="block mt-1" type="text" name="description" :value="old('description')" required autofocus autocomplete="description" />
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="flex justify-end mt-4">
                                    <x-primary-button>
                                        {{ __('Modify') }}
                                    </x-primary-button>
                                </div>
                            </form>

                        </div> -->

                        <div class="main-content">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Metrics</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($descriptions as $description)
                                        <tr>
                                            <td><b>{{ $description['column_title'] }}</b></td>
                                            <td>{{ $description['description'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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