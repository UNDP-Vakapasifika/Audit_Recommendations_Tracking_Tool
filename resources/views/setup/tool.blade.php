<x-guest-layout>
    <form method="POST" action="{{ route('setup.tool') }}" enctype="multipart/form-data">
        @csrf

        <h2 class="text-2xl text-center font-bold mb-6">Setup Tool Details</h2>
        
        <!-- Container for fields -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 xl:gap-6">
            
            <!-- Tool Name -->
            <div class="col-span-1">
                <x-input-label for="tool_name" :value="__('Tool Name')" />
                <x-text-input id="tool_name" class="block mt-1 w-full" type="text" name="tool_name" :value="old('tool_name')" required autofocus />
                <x-input-error :messages="$errors->get('tool_name')" class="mt-2" />
            </div>

            <!-- Tool Logo -->
            <div class="col-span-1">
                <x-input-label for="logo" :value="__('Tool Logo')" />
                <x-text-input id="logo" class="block mt-1 w-full" type="file" name="logo" accept="image/*" required />
                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center mt-6">
            <x-primary-button>
                {{ __('Next') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
