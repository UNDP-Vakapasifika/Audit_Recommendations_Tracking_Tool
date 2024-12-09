@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Conversations</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- component -->
                    <div class="flex h-screen antialiased text-gray-800">
                        <div class="flex flex-row h-full w-full overflow-x-auto">
                            <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">

                                <div class="flex flex-col">
                                    <div class="flex flex-row items-center justify-between text-xs">
                                        <span class="font-bold">Active Conversations</span>
                                        <span class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">
                                            {{ count($conversations) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col space-y-1 mt-4 -mx-2 h-full overflow-y-auto">
                                        @forelse ($conversations as $item)
                                        <a href="{{route('messages.show', $item->id)}}" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2 ">
                                            <div
                                                class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">
                                                {{Str::limit($item->report->audit_report_title, 1, '')}}
                                            </div>
                                            <div class="ml-2 text-sm font-semibold">
                                                {{Str::limit($item->report->audit_report_title, 20, '..')}}
                                            </div>
                                        </a>
                                        @empty
                                            <div>
                                                <p>No conversations yet</p>
                                            </div>
                                        @endforelse

                                    </div>

                                </div>
                            </div>
                            <div class="flex flex-col flex-auto h-full p-4">
                                <div class="flex flex-col flex-auto flex-shrink-0 rounded-lg bg-gray-100 h-full p-2">
                                    <div class="flex flex-col h-full overflow-x-auto mb-4">
                                        @if (isset($messages_are_loaded))
                                            <div class="flex flex-col h-full">
                                                <div class="grid grid-cols-12 gap-y-2">
                                                    @foreach ($conversation->messages as $message)
                                                        @if ($message->sender_id == Auth::id())
                                                            <div class="col-start-6 col-end-13 p-3 rounded-lg">
                                                                <div
                                                                    class="flex items-center justify-start flex-row-reverse">
                                                                    <div
                                                                        class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 flex-shrink-0">
                                                                        A
                                                                    </div>
                                                                    <div
                                                                        class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                                                        <div>
                                                                            {{ $message->content }}
                                                                        </div>
                                                                        <div
                                                                            class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                                                                            {{ $message->created_at->format('h:i A') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                                                <div class="flex flex-row items-center">
                                                                    <div
                                                                        class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-500 flex-shrink-0">
                                                                        A
                                                                    </div>
                                                                    <div
                                                                        class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                                                        <div>{{ $message->content }}</div>
                                                                        <div
                                                                            class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500">
                                                                            {{ $message->created_at->format('h:i A') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-center items-center my-auto">
                                                <p>Click on any conversation to view the messages</p>
                                            </div>
                                        @endif
                                    </div>
                                    @if (isset($messages_are_loaded))
                                        <div >
                                            <form action="{{ route('messages.reply') }}" method="post"
                                                class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">
                                                @csrf
                                                <div class="flex-grow ml-4">
                                                    <div class="relative w-full">
                                                        <input type="text" name="content" value="{{ old('content') }}" required
                                                            class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" />
                                                        <input hidden name="conversation_id" value="{{ $conversation->id }}" />

                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <button type="submit"
                                                        class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                                                        <span>Send</span>
                                                        <span class="ml-2">
                                                            <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
