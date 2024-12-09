@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Stakeholder Settings</h3>
        <div class="flex gap-2">
            @if (auth()->user()->can('create lead bodies'))
                <a href="{{ route('stakeholder.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Stakeholder
                </a>
            @endif
        </div>
        
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4"></h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <div class="p-4">
                    <table class="w-full border border-gray-200 mt-3" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Stakeholder Name</th>
                                <th class="border border-gray-200 px-4 py-2">Location</th>
                                <th class="border border-gray-200 px-4 py-2">Users Count</th>
                                <th class="border border-gray-200 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Iterate through each entry in the data array -->
                            @foreach ($stakeholders as $stakeholder)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $stakeholder->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $stakeholder->location }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $stakeholder->users->count() }}</td>
                                    <td class="border border-gray-200 px-4 py-2 flex gap-3">
                                        <!-- Include the existing actions for editing, viewing, and deleting -->
                                        @if (auth()->user()->can('edit lead bodies'))
                                            <a href="{{ route('stakeholder.edit', $stakeholder->id) }}" class="text-blue-500 hover:underline">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        @endif
                                        <a href="{{ route('stakeholder.show', $stakeholder->id) }}" class="mr-3"
                                           title="View Records" data-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                        </a>
                                        @if (auth()->user()->can('delete lead bodies'))
                                            <form class="delete_item" action="{{ route('stakeholder.destroy', $stakeholder->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete Record" data-toggle="tooltip" class="text-red-500 ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
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
