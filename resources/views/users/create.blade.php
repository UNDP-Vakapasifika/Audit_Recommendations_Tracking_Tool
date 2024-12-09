@extends('layouts.master')

@section('body')

    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">
            {{ isset($user) ? 'Edit User' : 'Add New User' }}
        </h3>
        <a href="{{ route('users.index') }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Back to Catehories
        </a>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold mb-4"></h2>
                <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
            </div>

            @if(request()->routeIs('users.create'))
                <p class="text-gray-900 mb-3">User will be created with a strong random password and it will be sent to their email address</p>
            @endif
            
            <form method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="">
                        <x-input-label for="email" :value="__('Full Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      value="{{isset($user) ? $user->name : old('name')}}" required autofocus
                                      autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="">
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                      value="{{isset($user) ? $user->email : old('email')}}" required/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div class="">
                        <x-input-label for="lead_body_id" :value="__('Client')"/>
                        <select 
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            name="lead_body_id">
                            <option></option>
                            @foreach($leadBodies as $body)
                                <option
                                    value="{{$body->id}}" {{isset($user) && $user->lead_body_id == $body->id ? 'selected' : ''}}>{{$body->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('lead_body_id')" class="mt-2"/>
                    </div>
                    <div class="">
                        <x-input-label for="lead_body_id" :value="__('Stakeholder')"/>
                        <select 
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            name="stakeholder_id">
                            <option></option>
                            @foreach($stakeholders as $stakeholder)
                                <option
                                    value="{{$stakeholder->id}}" {{isset($user) && $user->stakeholder_id == $stakeholder->id ? 'selected' : ''}}>{{$stakeholder->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('stakeholder_id')" class="mt-2"/>
                    </div>
                    <div class="">
                        <x-input-label for="role" :value="__('Role')"/>
                        <select required
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            name="role">
                            <option></option>
                            @foreach($roles as $role)
                                <option
                                    value="{{$role->name}}" {{isset($user) && $user->roles->first()?->name == $role->name ? 'selected' : ''}}>{{$role->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2"/>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ isset($user) ? 'Update user' : 'Save user' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

@endsection
