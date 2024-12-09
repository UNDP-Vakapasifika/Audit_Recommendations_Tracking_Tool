@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        Edit Stakeholder
    </h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold mb-4"></h2>
                    <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                </div>
                
                <form method="POST" action="{{ route('stakeholder.update', $stakeholder->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div class="">
                            <x-input-label for="name" :value="__('Stakeholder Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          value="{{ $stakeholder->name }}" required autofocus
                                          autocomplete="name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                        <div class="">
                            <x-input-label for="location" :value="__('Location')"/>
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                                          value="{{ $stakeholder->location }}"
                                          autocomplete="location"/>
                            <x-input-error :messages="$errors->get('location')" class="mt-2"/>
                        </div>
                        <div class="">
                            <x-input-label for="postal_address" :value="__('Postal Address')"/>
                            <x-text-input id="postal_address" class="block mt-1 w-full" type="text" name="postal_address"
                                          value="{{ $stakeholder->postal_address }}"
                                          autocomplete="postal_address"/>
                            <x-input-error :messages="$errors->get('postal_address')" class="mt-2"/>
                        </div>
                        <div class="">
                            <x-input-label for="telephone" :value="__('Telephone')"/>
                            <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone"
                                          value="{{ $stakeholder->telephone }}"
                                          autocomplete="telephone"/>
                            <x-input-error :messages="$errors->get('telephone')" class="mt-2"/>
                        </div>
                        <div class="">
                            <x-input-label for="email" :value="__('Email')"/>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                          value="{{ $stakeholder->email }}"
                                          autocomplete="email"/>
                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                        </div>
                        <div class="">
                            <x-input-label for="website" :value="__('Website')"/>
                            <x-text-input id="website" class="block mt-1 w-full" type="text" name="website"
                                          value="{{ $stakeholder->website }}"
                                          autocomplete="website"/>
                            <x-input-error :messages="$errors->get('website')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button class="ms-3">
                            Update
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
