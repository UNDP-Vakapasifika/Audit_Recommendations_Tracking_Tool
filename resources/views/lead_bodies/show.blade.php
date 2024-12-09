@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        {{$leadBody->name}} Details
    </h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-3">Client Users</h1>
                    @forelse($leadBody->users as $user)
                        <a href="{{ route('users.show', $user->id) }}"
                            class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $user->name }}</a>
                    @empty
                        <p class="text-gray-700 mb-3">body has no users</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
