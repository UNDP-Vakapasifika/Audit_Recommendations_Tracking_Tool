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
                                        <span
                                            class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">
                                            {{count($conversations)}}
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
                                        
                                            <div class="flex justify-center items-center my-auto">
                                                <p>Click on any conversation to view the messages</p>
                                            </div>
                                    
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
