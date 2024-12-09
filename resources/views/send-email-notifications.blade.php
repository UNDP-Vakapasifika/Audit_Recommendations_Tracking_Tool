<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Email Notifications') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('send.email.notifications') }}" method="get">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Send Email Notifications
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
