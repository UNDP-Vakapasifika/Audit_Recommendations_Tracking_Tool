@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Edit Client Type</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form method="POST" action="{{ route('client-types.update', $clientType->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div>
                            <x-input-label for="name" :value="__('Client Type Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          value="{{ $clientType->name }}" required autofocus autocomplete="name"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>
                            Update
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
