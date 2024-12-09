@extends('layouts.master')

@section('body')
    <div class="container mx-auto py-8">
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf

            <h2 class="text-2xl text-center font-bold mb-6">Update Tool Settings</h2>
            
            <!-- Container for fields -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 xl:gap-6">
                
                <!-- Tool Name -->
                <div class="col-span-1">
                    <x-input-label for="tool_name" :value="__('Tool Name')" />
                    <x-text-input id="tool_name" class="block mt-1 w-full" type="text" name="tool_name" :value="$tool->tool_name ?? old('tool_name')" required autofocus />
                    <x-input-error :messages="$errors->get('tool_name')" class="mt-2" />
                </div>

                <!-- Tool Logo -->
                <div class="col-span-1">
                    <x-input-label for="logo" :value="__('Tool Logo')" />
                    <x-text-input id="logo" class="block mt-1 w-full" type="file" name="logo" accept="image/*" />
                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    
                    <!-- Display current logo if available -->
                    @if($tool && $tool->logo_path)
                        <div class="mt-4">
                            <img src="{{ asset($tool->logo_path) }}" alt="{{ $tool->tool_name }}" class="h-16 w-16">
                            <p class="text-sm text-gray-500">{{ __('Current Logo') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <x-primary-button>
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
