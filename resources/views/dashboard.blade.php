@extends('layouts.master')

@section('body')
    <h3 class="page-heading" >Dashboard</h3>

    <div class="mt-4">
        <div class="flex flex-wrap -mx-1">
            <div class="w-full px-2 sm:w-1/2 xl:w-1/4">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </div>
                    <a href="{{route('reports')}}#fully_implemented">
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{$fullyImplementedCount}}</h4>
                            <div class="text-gray-500">Fully Implemented</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="w-full mt-6 px-2 sm:w-1/2 xl:w-1/4 sm:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                    <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                        </svg>

                    </div>
                    <a href="{{ route('reports') }}#partly_implemented ">
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{$partiallyImplementedCount}}</h4>
                            <div class="text-gray-500">Partially Implemented</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="w-full mt-6 px-2 sm:w-1/2 xl:w-1/4 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                    <div class="p-3 rounded-full bg-blue-800 bg-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 text-white h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </div>
                    <a href="{{route('reports')}}#noupdate_implementation">
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{$noupdateImplementedCount}}</h4>
                            <div class="text-gray-500">No Update</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="w-full mt-6 px-2 sm:w-1/2 xl:w-1/4 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white h-full">
                    <div class="p-3 rounded-full bg-orange-800 bg-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <a href="{{route('reports')}}#not_implemented">
                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">{{$notImplementedCount}}</h4>
                            <div class="text-gray-500">Not Implemented</div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-4 md:pt-6 xl:pt-8">
        <h3 class="page-subheading">Event Tracking Calendar</h3>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

<div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
    <h3 class="text-xl font-semibold text-gray-700 px-6 py-4">User Activity Summary</h3>
    <ul>
        @foreach($userActivityCounts as $userActivity)
            <li class="border-t border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="text-sm font-medium text-gray-900">
                        {{ $userActivity->user->name }} ({{ $userActivity->activity_count }} activities)
                    </div>
                    <div>
                        <button id="toggleBtn-{{ $userActivity->user_id }}" 
                                onclick="toggleActivities('{{ $userActivity->user_id }}')" 
                                class="text-blue-500 hover:underline">View Activities</button>
                    </div>
                </div>

                <!-- Activities Toggler -->
                <div id="activities-{{ $userActivity->user_id }}" style="display:none;" class="mt-4">
                    <ul>
                        @foreach($recentActivities[$userActivity->user_id] as $activity)
                            <li class="text-sm text-gray-500 py-1">
                                {{ $activity->description }} - {{ $activity->created_at->diffForHumans() }}
                            </li>
                        @endforeach
                    </ul>
                    @if($userActivity->activity_count > 5)
                        <button class="text-blue-500 hover:underline mt-2" 
                                onclick="showAllActivitiesModal('{{ $userActivity->user_id }}', '{{ $userActivity->user->name }}')">See more</button>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

<!-- Modal for displaying all activities -->
<div id="allActivitiesModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-md max-h-[80vh] p-6 relative">
        <div class="overflow-y-auto h-full">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">All Activities for <span id="modalUserName"></span></h3>
            <ul id="allActivitiesList" class="space-y-2">
                <!-- Activities will be injected here -->
            </ul>
        </div>
        <button class="absolute top-3 right-3 text-red-500 hover:text-gray-700" onclick="closeModal()">
            Close Window
        </button>
    </div>
</div>

<script>
    function toggleActivities(userId) {
        var activitiesDiv = document.getElementById('activities-' + userId);
        var toggleBtn = document.getElementById('toggleBtn-' + userId);
        
        if (activitiesDiv.style.display === 'none') {
            activitiesDiv.style.display = 'block';
            toggleBtn.textContent = 'Hide Activities';
        } else {
            activitiesDiv.style.display = 'none';
            toggleBtn.textContent = 'View Activities';
        }
    }

    function showAllActivitiesModal(userId, userName) {
        // Set the user name in the modal
        document.getElementById('modalUserName').textContent = userName;
        
        // Get all activities for the user
        var activities = @json($recentActivities);

        // Clear previous activities
        var activitiesList = document.getElementById('allActivitiesList');
        activitiesList.innerHTML = '';

        // Append new activities
        activities[userId].forEach(function(activity) {
            var listItem = document.createElement('li');
            listItem.textContent = activity.description + ' - ' + activity.created_at;
            activitiesList.appendChild(listItem);
        });

        // Show the modal
        document.getElementById('allActivitiesModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('allActivitiesModal').style.display = 'none';
    }
</script>


@endsection

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <style>
        #calendar {
            margin: 0 auto;
            max-height: 540px;
        }
    </style>
@endsection

@section('scripts')

    {{-- calendar --}}
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    right: 'prev,next today',
                    left: 'title',
                    center: ''
                },
                events :{!! json_encode($calendarEvents) !!},

                eventMouseEnter: function(info) {
                    info.el.style.cursor = 'pointer';
                },

                eventMouseLeave: function(info) {
                    info.el.style.cursor = '';
                },

                eventClick: function(info) {
                    const localDate = new Date(info.event.start);
                    localDate.setDate(localDate.getDate());
                    const formattedDate = localDate.toISOString().split('T')[0]; //add one day to this

                    window.location.href = '{{ route('reports.due') }}?date=' + formattedDate;
                }
        })
            calendar.render()
        })
    </script>

@endsection
