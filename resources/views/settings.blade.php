@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Users</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- {{ __("Charts Content ") }} -->
                    <h1 class="text-2xl font-bold text-center mb-4">User Settings</h1>

                    <div class="p-4">

                        <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Name</th>
                                    <th class="border border-gray-200 px-4 py-2">Email</th>
                                    <th class="border border-gray-200 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            {{-- Add actions here (e.g., Edit, Delete, etc.) --}}
                                            <a href="{{ route('listUsers', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <a href="{{ route('updateuser', ['id' => $user['id']]) }}" class="mr-3"
                                            title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                            <a href="{{ route('deleteuser', ['id' => $user['id']]) }}" title="Delete Record"
                                            data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                        
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