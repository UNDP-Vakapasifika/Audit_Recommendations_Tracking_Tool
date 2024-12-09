@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Audit Users</h3>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- <h1 class="text-2xl font-bold text-center mb-4">Audit Practitioners</h1> -->
                    <div class="flex justify-center mt-4">
                        <!-- <x-primary-button>
                            <a href="{{ route('audit-practitioners.index') }}" >
                                <i class="fa fa-plus"></i> Stakeholder
                            </a>
                        </x-primary-button> -->

                        <div x-data="{ showModal: false }">
                            <!-- Button to open the modal -->
                            @if(auth()->user()->can('create stakeholders'))
                                
                            <x-primary-button class="flex justify-end" @click="showModal = true">
                                <i class="fa fa-plus"></i> {{ __(' Add New') }}
                            </x-primary-button>
                            @endif

                            <!-- Modal -->
                            <div x-show="showModal" class="fixed inset-0 overflow-y-auto">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <!-- Background overlay -->
                                    <div x-show="showModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <!-- Modal Panel -->
                                    <div x-show="showModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <form action="{{ route('audit-practitioners.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <!-- Name -->
                                            <div class="mt-4 px-6">
                                                <x-input-label for="name" :value="__('Name')" />
                                                <input id="name" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="name" :value="old('name')" required autofocus />
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>
                                            <!-- Email Address -->
                                            <div class="mt-4 px-6">
                                                <x-input-label for="email" :value="__('Email Address')" />
                                                <input id="email" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="email" name="email" :value="old('email')" required />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Role -->
                                            <div class="mt-4 px-6">
                                                <x-input-label for="role" :value="__('Role')" />
                                                <select id="role" name="role" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                                    <option value="Head of Audited Entity">Head of Audited Entity</option>
                                                    <option value="Audit Supervisor">Audit Supervisor</option>
                                                    <option value="Audited Entity Focal Point">Audited Entity Focal Point</option>
                                                    <option value="Team Leader">Team Leader</option>
                                                    <option value="Internal Auditor">Internal Auditor</option>
                                                    <option value="President">CSO President</option>
                                                </select>
                                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                            </div>

                                            <!-- Audit Department -->
                                            <div class="mt-4 px-6">
                                                <x-input-label for="audit_department" :value="__('Stakeholder')" />
                                                <select id="audit_department" name="audit_department" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                                    <option value="Executive">Executive</option>
                                                    <option value="Treasury">Treasury</option>
                                                    <option value="Judiciary">Judiciary</option>
                                                    <option value="Legislature">Legislature</option>
                                                    <option value="CSO">CSO</option>
                                                    <option value="Media">Media</option>
                                                </select>
                                                <x-input-error :messages="$errors->get('audit_department')" class="mt-2" />
                                            </div>

                                            <!-- Work Number -->
                                            <div class="mt-4 px-6">
                                                <x-input-label for="employment_number" :value="__('Office ID No.')" />
                                                <input id="employment_number" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" type="text" name="employment_number" :value="old('employment_number')" />
                                                <x-input-error :messages="$errors->get('employment_number')" class="mt-2" />
                                            </div>

                                            <div class="flex justify-between items-center p-6 bg-gray-50">
                                                <x-primary-button type="submit" >
                                                    {{ __(' Save') }}
                                                </x-primary-button>

                                                <!-- <x-primary-button @click.prevent="showModal = false">
                                                    {{ __('Cancel') }}
                                                </x-primary-button> -->

                                                <x-primary-button onclick="cancelAndReload(event)">
                                                    <i class="fa fa-times"></i> {{ __('Cancel') }}
                                                </x-primary-button>

                                                <script>
                                                    function cancelAndReload(event) {
                                                        event.preventDefault();
                                                        location.reload();
                                                    }
                                                </script>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Name</th>
                                    <th class="border border-gray-200 px-4 py-2">Email</th>
                                    <th class="border border-gray-200 px-4 py-2">Role</th>
                                    <th class="border border-gray-200 px-4 py-2">Stakeholder</th>
                                    <th class="border border-gray-200 px-4 py-2">Office ID Number</th>
                                    <th class="border border-gray-200 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($practitioners as $practitioner)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ $practitioner->name }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $practitioner->email }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $practitioner->role }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $practitioner->audit_department }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $practitioner->employment_number }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            @if(auth()->user()->can('edit stakeholders'))
                                            <a href="{{ route('audit-practitioners.edit', $practitioner->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                            @endif

                                            @if(auth()->user()->can('delete stakeholders'))
                                            <form action="{{ route('audit-practitioners.destroy', $practitioner->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const closeButtons = document.querySelectorAll('.close-button');

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.parentElement.style.display = 'none';
                });
            });
        });
    </script>
@endsection
