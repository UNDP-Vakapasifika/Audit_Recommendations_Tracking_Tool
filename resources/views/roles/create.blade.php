@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        {{ isset($role) ? 'Edit Role' : 'Add New Role' }}
    </h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold mb-4"></h2>
                <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
            </div>
            <form method="POST" action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}">
                @csrf
                @if(isset($role))
                    @method('PUT')
                @endif
                <div class="flex flex-col gap-3">
                    <div class="">
                        <x-input-label for="name" :value="__(' Name')"/>
                        <x-text-input id="name" class="block mt-1 w-1/4" type="text" name="name"
                                      value="{{isset($role) ? $role->name : old('name')}}" required autofocus
                                      autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <x-input-label for="name" :value="__(' Permissions')"/>
                    <div class="flex flex-wrap gap-x-6">
                        @foreach($permissions as $permission)
                            <div class="mb-3 mr-3">
                                <input type="checkbox" name="permissions[]" value="{{$permission}}"
                                       @if(isset($role_permissions) && $role_permissions->contains($permission)) checked @endif>
                                <label class="inline-block ml-1">{{$permission}}</label>
                            </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('permissions')" class="mt-2"/>


                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ isset($role) ? 'Update role' : 'Save role' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection