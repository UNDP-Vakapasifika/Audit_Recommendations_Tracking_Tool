@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Edit User</h3>

    <div class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4"></h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <form method="POST" action="{{ route('audit-practitioners.update', $audit_practitioner->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <input id="name" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="name" value="{{ old('name', $audit_practitioner->name) }}" required autofocus />
                            <!-- <input id="name" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="name" :value="{{ $audit_practitioner->name }}" required autofocus /> -->
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <input id="email" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" name="email" value="{{ old('email', $audit_practitioner->email) }}" required />
                            <!-- <input id="email" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" name="email" :value="{{ $audit_practitioner->email }}" required /> -->
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="Head of Audited Entity" {{ $audit_practitioner->role == 'Head of Audited Entity' ? 'selected' : '' }}>Head of Audited Entity</option>
                                <option value="Audit Supervisor" {{ $audit_practitioner->role == 'Audit Supervisor' ? 'selected' : '' }}>Audit Supervisor</option>
                                <option value="Audited Entity Focal Point" {{ $audit_practitioner->role == 'Audited Entity Focal Point' ? 'selected' : '' }}>Audited Entity Focal Point</option>
                                <option value="Team Leader" {{ $audit_practitioner->role == 'Team Leader' ? 'selected' : '' }}>Team Leader</option>
                                <option value="Internal Auditor" {{ $audit_practitioner->role == 'Internal Auditor' ? 'selected' : '' }}>Internal Auditor</option>
                                <option value="CSO" {{ $audit_practitioner->role == 'CSO Presiden' ? 'selected' : '' }}>CSO President</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Audit Department -->
                        <div class="mt-4">
                            <x-input-label for="audit_department" :value="__('Stakeholder')" />
                            <select id="audit_department" name="audit_department" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="Executive" {{ $audit_practitioner->audit_department == 'Executive' ? 'selected' : '' }}>Executive</option>
                                <option value="Treasury" {{ $audit_practitioner->audit_department == 'Treasury' ? 'selected' : '' }}>Treasury</option>
                                <option value="Judiciary" {{ $audit_practitioner->audit_department == 'Judiciary' ? 'selected' : '' }}>Judiciary</option>
                                <option value="Legislature" {{ $audit_practitioner->audit_department == 'Legislature' ? 'selected' : '' }}>Legislature</option>
                                <option value="CSO" {{ $audit_practitioner->audit_department == 'CSO' ? 'selected' : '' }}>CSO</option>
                                <option value="Media" {{ $audit_practitioner->audit_department == 'Media' ? 'selected' : '' }}>Media</option>
                            </select>
                            <x-input-error :messages="$errors->get('audit_department')" class="mt-2" />
                        </div>

                        <!-- Employment Number -->
                        <div class="mt-4">
                            <x-input-label for="employment_number" :value="__('Office ID No.')" />
                            <input id="employment_number" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="employment_number" value="{{ old('employment_number', $audit_practitioner->employment_number) }}" />
                            <!-- <input id="employment_number" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="employment_number" :value="$practitioner->employment_number" /> -->
                            <x-input-error :messages="$errors->get('employment_number')" class="mt-2" />
                        </div>

                        <div class="flex text-center justify-center mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>
                            <!-- <x-primary-button class='ml-2'>
                                <a href="{{ route('audit-practitioners.show') }}" class="">Cancel</a>
                            </x-primary-button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
