@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Users</h3>
        @if(auth()->user()->can('create user'))
            <a href="{{ route('users.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New User
            </a>
        @endif
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Admins Section -->
                    <div class="p-4">
                        <h4 class="text-lg font-bold mb-4">Admins</h4>
                        <input type="text" id="adminSearchInput" placeholder="Search Admins..." class="mb-4 px-4 py-2 border rounded">
                        @if($admins->isEmpty())
                            <p class="text-gray-500">No records found.</p>
                        @else
                            <table class="w-full border border-gray-200 mt-3" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2" style="width: 50px;">#</th>
                                        <th class="border border-gray-200 px-4 py-2">Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Email</th>
                                        <th class="border border-gray-200 px-4 py-2">Rating</th>
                                        <th class="border border-gray-200 px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminTableBody">
                                    @foreach ($admins as $index => $admin)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $admin->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $admin->email }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @for ($i = 0; $i < $admin->rating; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 text-yellow-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.9 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
                                                @for ($i = $admin->rating; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 text-gray-300">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.9 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2 flex gap-3">
                                                <!-- Actions -->
                                                @if(auth()->user()->can('edit user'))
                                                    <a href="{{ route('users.edit', $admin->id) }}" class="text-blue-500 hover:underline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Stakeholders Section -->
                    <div class="p-4">
                        <h4 class="text-lg font-bold mt-8 mb-4">Stakeholders</h4>
                        <input type="text" id="stakeholderSearchInput" placeholder="Search Stakeholders..." class="mb-4 px-4 py-2 border rounded">
                        @if($stakeholders->isEmpty())
                            <p class="text-gray-500">No records found.</p>
                        @else
                            <table class="w-full border border-gray-200 mt-3" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2" style="width: 50px;">#</th>
                                        <th class="border border-gray-200 px-4 py-2">Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Role</th>
                                        <th class="border border-gray-200 px-4 py-2" style="width: 100px;">Total Users</th>
                                    </tr>
                                </thead>
                                <tbody id="stakeholderTableBody">
                                    @foreach ($stakeholders->unique('stakeholder_id') as $index => $stakeholder)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                <a href="{{ route('users.stakeholder', $stakeholder->stakeholder_id) }}" class="text-blue-500 hover:underline">
                                                    {{ $stakeholder->stakeholder->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2">Stakeholder</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $stakeholders->where('stakeholder_id', $stakeholder->stakeholder_id)->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Clients Section -->
                    <div class="p-4">
                        <h4 class="text-lg font-bold mt-8 mb-4">Clients</h4>
                        <input type="text" id="clientSearchInput" placeholder="Search Clients..." class="mb-4 px-4 py-2 border rounded">
                        @if($clients->isEmpty())
                            <p class="text-gray-500">No records found.</p>
                        @else
                            <table class="w-full border border-gray-200 mt-3" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2" style="width: 50px;">#</th>
                                        <th class="border border-gray-200 px-4 py-2">Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Role</th>
                                        <th class="border border-gray-200 px-4 py-2" style="width: 100px;">Total Users</th>
                                        <th class="border border-gray-200 px-4 py-2">Rating</th>
                                    </tr>
                                </thead>
                                <tbody id="clientTableBody">
                                    @foreach ($clients->unique('lead_body_id') as $index => $client)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                <a href="{{ route('users.client', $client->lead_body_id) }}" class="text-blue-500 hover:underline">
                                                    {{ $client->leadBody->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2">Client</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $clients->where('lead_body_id', $client->lead_body_id)->count() }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @for ($i = 0; $i < $client->rating; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 text-yellow-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.9 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
                                                @for ($i = $client->rating; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4 text-gray-300">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.9 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endfor
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
            // Function to filter table rows based on search input
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

            // Initialize filters for each table
            filterTable('adminSearchInput', 'adminTableBody');
            filterTable('stakeholderSearchInput', 'stakeholderTableBody');
            filterTable('clientSearchInput', 'clientTableBody');
        });

    </script>
@endsection
