@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        {{ isset($lead_body) ? 'Edit Client' : 'Add New Category' }}
    </h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold mb-4"></h2>
                <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
            </div>
            
            <form method="POST" action="{{ isset($lead_body) ? route('mainstream_category.update', $lead_body->id) : route('mainstream_category.store') }}">
                @csrf
                @if(isset($lead_body))
                    @method('PUT')
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="">
                        <x-input-label for="email" :value="__('Category Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      value="{{isset($lead_body) ? $lead_body->name : old('name')}}" required autofocus
                                      autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ isset($lead_body) ? 'Update' : 'Save' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

@endsection
