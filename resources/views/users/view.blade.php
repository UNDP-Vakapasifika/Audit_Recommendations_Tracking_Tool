@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Users</h3>
        @if(auth()->user()->can('create user'))
            <a href="{{route('users.create')}}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New User
            </a>
        @endif
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="p-4">
                        <table class="w-full border border-gray-200 mt-3"
                               style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Name</th>
                                <th class="border border-gray-200 px-4 py-2">Email</th>
                                <th class="border border-gray-200 px-4 py-2">Client</th>
                                <th class="border border-gray-200 px-4 py-2">Stakeholder</th>
                                <th class="border border-gray-200 px-4 py-2">Role</th>
                                <th class="border border-gray-200 px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->leadBody?->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->stakeholder?->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $user->roles?->first()?->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2 flex gap-3">
                                        @if(auth()->user()->can('edit user'))
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="text-blue-500 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                            </svg>
                                        </a>
                                        @endif
                                        @if(auth()->user()->can('view user'))
                                        <a href="{{ route('users.show', $user->id) }}" class="mr-3"
                                           title="Update Record" data-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                        </a>
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

@endsection
