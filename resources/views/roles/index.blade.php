@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
    <h3 class="page-heading">System Roles</h3>
        @if(auth()->user()->can('create role'))
            <a href="{{route('roles.create')}}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">Add New Role</a>
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
                                <th class="border border-gray-200 px-4 py-2">Permissions</th>
                                <th class="border border-gray-200 px-4 py-2">Users</th>
                                <th class="border border-gray-200 px-4 py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $role->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $role->permissions_count }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $role->users_count }}</td>
                                    <td class="border border-gray-200 px-4 py-2 flex gap-3">
                                        @if(auth()->user()->can('edit role'))
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                               class="text-blue-500 hover:underline">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if(auth()->user()->can('delete role'))
                                            <form class="delete_item" action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete Record" data-toggle="tooltip"
                                                        class="text-red-500 ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
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

@endsection
