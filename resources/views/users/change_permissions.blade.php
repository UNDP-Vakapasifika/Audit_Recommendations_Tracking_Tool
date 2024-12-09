@extends('layouts.master')

@section('body')

    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">
            Permissions for {{$user->name}}
        </h3>
        <a href="{{ route('users.index') }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Back to Catehories
        </a>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div class="">
                        <h1 class="text-xl font-bold mb-3">Tick to select or unselect</h1>

                        <form method="POST" action="{{ route('users.change-permissions', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-wrap gap-x-6">
                                @foreach($all_permissions as $permission)
                                    <div class="mb-3 mr-3">
                                        <input type="checkbox" name="permissions[]" value="{{$permission}}"
                                               @if($user_permissions->contains($permission)) checked @endif>
                                        <label class="inline-block ml-1">{{$permission}}</label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
