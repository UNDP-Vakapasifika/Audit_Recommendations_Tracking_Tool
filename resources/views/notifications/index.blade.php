@extends('layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="page-heading">Notifications</h3>
        @if (count($notifications) > 0)
            <div class="flex flex-row gap-1">
                <a href="{{ route('notifications.mark-all-as-read') }}"
                    class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500"> 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </a>
                <form class="delete_item" action="{{ route('notifications.delete-all') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
        @endif

    </div>

    <div class="flex flex-col mt-4">
        @forelse ($notifications as $notification)
            <div class="bg-white shadow-md rounded-md overflow-hidden mt-2">
                <div class="px-6 py-4">
                    @if ($notification->type == 'App\Notifications\ReportCautionedNotification')
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            <a href="{{ route('notifications.show', ['type' => 'caution', 'resourceId' => $notification->data['id'], 'notificationId' => $notification->id]) }}"
                                class="flex flex-col">
                                <span class="text-gray-400 text-sm">Report Cautioned</span>
                                <span
                                    class="text-gray-700 {{ $notification->read_at == null ? 'font-bold' : '' }}">{{ $notification->data['title'] }}</span>
                            </a>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                <span class="text-gray-700">{{ $notification->created_at->diffForHumans() }}</span>

                                <div class="flex flex-row gap-1">
                                    @if ($notification->read_at == null)
                                        <a href="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form class="delete_item"
                                        action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.
                                                            964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($notification->type == 'App\Notifications\ActionPlanSupervisedNotification')
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            <a href="{{ route('notifications.show', ['type' => 'supervised', 'resourceId' => $notification->data['id'], 'notificationId' => $notification->id]) }}"
                                class="flex flex-col">
                                <span class="text-gray-400 text-sm">Action Plan Supervised</span>
                                <span
                                    class="text-gray-700 {{ $notification->read_at == null ? 'font-bold' : '' }}">The action plan for the audit report : {{ $notification->data['report_title'] }} has been {{$notification->data['status']}}</span>
                            </a>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                <span class="text-gray-700">{{ $notification->created_at->diffForHumans() }}</span>

                                <div class="flex flex-row gap-1">
                                    @if ($notification->read_at == null)
                                        <a href="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form class="delete_item"
                                        action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.
                                                            964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($notification->type == 'App\Notifications\RecommendationNotedNotification')
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            <a href="{{ route('notifications.show', ['type' => 'notes', 'resourceId' => $notification->data['id'], 'notificationId' => $notification->id]) }}"
                                class="flex flex-col">
                                <span class="text-gray-400 text-sm">Recommendation Notes</span>
                                <span
                                    class="text-gray-700 {{ $notification->read_at == null ? 'font-bold' : '' }}">{{ $notification->data['recommendation'] }}</span>
                            </a>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                <span class="text-gray-700">{{ $notification->created_at->diffForHumans() }}</span>

                                <div class="flex flex-row gap-1">
                                    @if ($notification->read_at == null)
                                        <a href="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form class="delete_item"
                                        action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.
                                                            964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($notification->type == 'App\Notifications\RemindReport30DayDueNotification')
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            <a href="{{ route('notifications.show', ['type' => 'due-30days', 'resourceId' => $notification->data['id'], 'notificationId' => $notification->id]) }}"
                                class="flex flex-col">
                                <span class="text-gray-400 text-sm">Recommendations Due in 30 days</span>
                                <span
                                    class="text-gray-700 {{ $notification->read_at == null ? 'font-bold' : '' }}">{{ $notification->data['report_title'] }} has {{ $notification->data['recom_count'] }} that are due in 30 days</span>
                            </a>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                <span class="text-gray-700">{{ $notification->created_at->diffForHumans() }}</span>

                                <div class="flex flex-row gap-1">
                                    @if ($notification->read_at == null)
                                        <a href="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form class="delete_item"
                                        action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.
                                                            964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($notification->type == 'App\Notifications\RemindStakeholders30DaySummaryNotification')
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            <a href="{{ route('notifications.show', ['type' => 'due-30days', 'resourceId' => $notification->data['id'], 'notificationId' => $notification->id]) }}"
                                class="flex flex-col">
                                <span class="text-gray-400 text-sm">Summary of Reminders for Recommendations Due in 30 days</span>
                                <span
                                    class="text-gray-700 {{ $notification->read_at == null ? 'font-bold' : '' }}">
                                    {{ $notification->data['unique_clients'] }} Client(s) have {{ $notification->data['total_reports'] }} audit report(s) with {{ $notification->data['total_recommendations'] }} recommendation(s) that are due in 30 days as of {{ $notification->data['date'] }}</span>
                            </a>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                <span class="text-gray-700">{{ $notification->created_at->diffForHumans() }}</span>

                                <div class="flex flex-row gap-1">
                                    @if ($notification->read_at == null)
                                        <a href="{{ route('notifications.mark-as-read', $notification->id) }}"
                                            class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form class="delete_item"
                                        action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.
                                                            964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white shadow-md rounded-md overflow-hidden mt-2">
                <div class="px-6 py-4">
                    <span class="text-gray-700">No notifications found</span>
                </div>
            </div>
        @endforelse
    </div>
@endsection
