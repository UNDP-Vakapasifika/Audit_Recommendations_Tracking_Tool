@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Permission Denied</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl md:text-7xl font-extrabold text-red-500 text-center">403</h1>

                    <h4 class=" text-textGrayOne text-center text-xl pb-4">Sorry, You don't have the right permission to perform
                        that operation</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
