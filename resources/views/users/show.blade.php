@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Users</h3>
        <a href="{{ route('users.index') }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Back to Catehories
        </a>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-3">{{$user->name}}<span class="text-gray-500">({{$user->roles->first()?->name}})</span>
                    </h1>
                    <p class="text-gray-700 mb-3">{{$user->email}}
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                @if(auth()->user()->can('view user permissions'))
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between">
                            <h1 class="text-xl font-bold mb-3">Permissions</h1>
                            @if(auth()->user()->can('assign permissions'))
                                <a href="{{ route('users.change-permissions-view', $user->id) }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        @forelse($permissions as $permission)
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{$permission->name}}</span>
                        @empty
                            <p class="text-gray-700 mb-3">User has no permissions</p>
                        @endforelse
                    </div>
                @endif
            </div>

            @if(auth()->user()->can('view user logs'))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-xl font-bold mb-3">Activity Log</h1>
                        <table class="w-full border border-gray-200 mt-3" id="logs"
                               style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Action</th>
                                <th class="border border-gray-200 px-4 py-2">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($user->activityLogs as $activity)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $activity->description }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $activity->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2 text-center" colspan="2">No activity
                                        found
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection


@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#logs').DataTable({});
        });
    </script>
@endsection
