@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">{{ $category }}: {{ $categoryName }}</h3>
        <a href="{{ route('users.index') }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Back to Categories
        </a>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Users Table Section -->
                    <div class="p-4">
                        <h4 class="text-lg font-bold mb-4">Users</h4>
                        <input type="text" id="userSearchInput" placeholder="Search Users..." class="mb-4 px-4 py-2 border rounded">
                        @if($users->isEmpty())
                            <p class="text-gray-500">No records found.</p>
                        @else
                            <table class="w-full border border-gray-200 mt-3"
                                style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Email</th>
                                        @if($users->first()->lead_body_id !== null)
                                            <th class="border border-gray-200 px-4 py-2">Client</th>
                                        @endif
                                        @if($users->first()->stakeholder_id !== null)
                                            <th class="border border-gray-200 px-4 py-2">Stakeholder</th>
                                        @endif
                                        <th class="border border-gray-200 px-4 py-2">Role</th>
                                        <th class="border border-gray-200 px-4 py-2">Rating</th>
                                        <th class="border border-gray-200 px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                                            @if($user->lead_body_id !== null)
                                                <td class="border border-gray-200 px-4 py-2">{{ $user->leadBody?->name }}</td>
                                            @endif
                                            @if($user->stakeholder_id !== null)
                                                <td class="border border-gray-200 px-4 py-2">{{ $user->stakeholder?->name }}</td>
                                            @endif
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->roles?->first()?->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @for ($i = 0; $i < $user->rating; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 text-yellow-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.9 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
                                                @for ($i = $user->rating; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 text-gray-300">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.9 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2 flex gap-3">
                                                @if(auth()->user()->can('edit user'))
                                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                                @if(auth()->user()->can('view user'))
                                                    <a href="{{ route('users.show', $user->id) }}" class="mr-3" title="Update Record" data-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                                @if(auth()->user()->can('delete user'))
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9h-15M10.5 12.75v5.25M13.5 12.75v5.25M4.5 9.75v9a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-9m-15 0v-2.25A2.25 2.25 0 0 1 7.5 5.25h9A2.25 2.25 0 0 1 18.75 7.5v2.25m-15 0h15"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if(auth()->user()->can('delete user'))
                                                    <form action="{{ route('users.makeAdmin', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to make this user an admin?');">
                                                        @csrf
                                                        <button type="submit" class="text-blue-500 hover:underline">
                                                            Make Admin
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function filterTable(inputId, tableBodyId) {
                const input = document.getElementById(inputId);
                const tableBody = document.getElementById(tableBodyId);
                const rows = tableBody.getElementsByTagName('tr');

                input.addEventListener('keyup', function () {
                    const filter = input.value.toLowerCase();

                    for (let i = 0; i < rows.length; i++) {
                        const cells = rows[i].getElementsByTagName('td');
                        let textContent = '';
                        for (let j = 0; j < cells.length; j++) {
                            textContent += cells[j].textContent.toLowerCase() + ' ';
                        }
                        rows[i].style.display = textContent.includes(filter) ? '' : 'none';
                    }
                });
            }

            // Initialize filter for the users table
            filterTable('userSearchInput', 'userTableBody');
        });
    </script>
@endsection
