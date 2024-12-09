<header class="flex items-center justify-between px-6 py-4 bg-white ">
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </button>

        <?php
            // Fetch the tool data directly if not passed to the view
            $tool = App\Models\Tool::first();
        ?>

        <div class="mx-4 lg:mx-0">
            <span class="mx-2 text-2xl font-semibold text-gray-800">
                {{ $tool->tool_name ?? 'Default Tool Name' }} Audit Recommendations Tracking Tool
            </span>
        </div>

    </div>

    <div class="flex items-center">
        <div class="relative flex items-center gap-4">
            <!-- Public Dashboard Button -->
            <a href="{{ route('home') }}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 3L2 12h3v6h14v-6h3L12 3z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Public
            </a>

            <!-- Notification Button -->
            <a href="{{ route('notifications.index') }}" class="relative">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-0 right-0 inline-block w-4 h-4 text-xs leading-none text-center text-white bg-red-500 rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>
        </div>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen"
                    class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                <img class="object-cover w-full h-full" src="{{asset('images/user-profile.jpg')}}" alt="Your avatar">
            </button>

            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false"
                 class="fixed inset-0 z-10 w-full h-full"></div>

            <div x-cloak x-show="dropdownOpen"
                 class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl">
                <a href="{{route('profile.edit')}}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                            onclick="event.preventDefault(); this.closest('form').submit();">Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
