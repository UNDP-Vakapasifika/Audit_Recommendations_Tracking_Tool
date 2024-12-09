<x-guest-layout>
    <form method="POST" action="{{ route('setup.sai') }}">
        @csrf

        <h2 class="text-2xl text-center font-bold mb-6">Setup SAI Details</h2>
        <!-- Container for fields -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 xl:gap-6">
            
            <!-- SAI Name -->
            <div class="col-span-1">
                <x-input-label for="name" :value="__('SAI Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Location -->
            <div class="col-span-1">
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <!-- Postal Address -->
            <div class="col-span-1">
                <x-input-label for="postal_address" :value="__('Postal Address')" />
                <x-text-input id="postal_address" class="block mt-1 w-full" type="text" name="postal_address" :value="old('postal_address')" required />
                <x-input-error :messages="$errors->get('postal_address')" class="mt-2" />
            </div>

            <!-- Telephone -->
            <div class="col-span-1">
                <x-input-label for="telephone" :value="__('Telephone')" />
                <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required />
                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-1">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Website -->
            <div class="col-span-1">
                <x-input-label for="website" :value="__('Website')" />
                <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" required />
                <x-input-error :messages="$errors->get('website')" class="mt-2" />
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
