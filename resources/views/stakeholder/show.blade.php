@extends('layouts.master')

@section('body')
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold mb-4">Stakeholder Details</h2>
                    <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                </div>
                <div class="mt-4">
                    <p><strong>Name:</strong> {{ $stakeholder->name }}</p>
                    <p><strong>Location:</strong> {{ $stakeholder->location }}</p>
                    <p><strong>Postal Address:</strong> {{ $stakeholder->postal_address }}</p>
                    <p><strong>Telephone:</strong> {{ $stakeholder->telephone }}</p>
                    <p><strong>Email:</strong> {{ $stakeholder->email }}</p>
                    <p><strong>Website:</strong> {{ $stakeholder->website }}</p>
                </div>

                <div class="mt-6">
                    <h4 class="font-bold text-lg">Associated Users</h4>
                    @if ($users->isEmpty())
                        <p>No users associated with this stakeholder.</p>
                    @else
                        <ul class="list-disc list-inside">
                            @foreach ($users as $user)
                                <li>{{ $user->name }} ({{ $user->email }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
