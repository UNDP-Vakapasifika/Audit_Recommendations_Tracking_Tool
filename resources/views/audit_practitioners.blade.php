@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Create Audit Users</h3>
    <div class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('audit-practitioners.store') }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <input id="name" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <input id="email" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="Head of Audited Entity">Head of Audited Entity</option>
                                <option value="Audit Supervisor">Audit Supervisor</option>
                                <option value="Audited Entity Focal Point">Audited Entity Focal Point</option>
                                <option value="Team Leader">Team Leader</option>
                                <option value="Internal Auditor">Internal Auditor</option>
                                <option value="CSO">CSO</option>

                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Audit Department -->
                        <div class="mt-4">
                            <x-input-label for="audit_department" :value="__('Stakeholder')" />
                            <select id="audit_department" name="audit_department" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="Ministry of Agriculture">Ministry of Agriculture</option>
                                <option value="Treasury">Treasury</option>
                                <option value="Judiciary">Judiciary</option>
                                <option value="Legislature">Legislature</option>
                            </select>
                            <x-input-error :messages="$errors->get('audit_department')" class="mt-2" />
                        </div>

                        <!-- Employment Number -->
                        <div class="mt-4">
                            <x-input-label for="employment_number" :value="__('Employment Number')" />
                            <input id="employment_number" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="employment_number" :value="old('employment_number')" />
                            <x-input-error :messages="$errors->get('employment_number')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Save') }}
                            </x-primary-button>
                            <x-primary-button class='ml-2'>
                                <a href="{{ route('audit-practitioners.show') }}" class="">Cancel</a>
                            </x-primary-button>
                        </div>
                    </form>
                <div>
            </div>
        </div>
    </div>
    
@endsection
