<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Action Planning') }}
        </h2>

        <form method="POST" action="{{ route('insertfinalreport') }}">
            @csrf
            <x-primary-button type="submit">
                {{ __('Update Final Report') }}
            </x-primary-button>
        </form>
    </div>
    </x-slot>

    <div class="flex justify-center mt-4">
        <x-primary-button>
            <a href="{{ route('action-plans.create') }}" >
                <i class="fa fa-plus"></i> Manual Plan
            </a>
        </x-primary-button>
        <x-primary-button class="ml-3">
            <a href="{{ route('dynamicaction') }}" >
                <i class="fa fa-plus"></i> Action Plan
            </a>
        </x-primary-button>
        <x-primary-button class="ml-3">
            <a href="{{ route('supervise') }}">
                <i class="fa fa-plus"></i> Supervise
            </a>
        </x-primary-button>

    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl text-center font-bold mb-4">Action Plans</h2>

                    <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                <th class="border border-gray-200 px-4 py-2">Country Office</th>
                                <th class="border border-gray-200 px-4 py-2">Date Created</th>
                                <th class="border border-gray-200 px-4 py-2">Created Person</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($uniqueReportDetails as $reportDetails)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2 text-blue-500 hover:underline">
                                        <a href="{{ route('report.details', ['id' => $reportDetails['id']]) }}">
                                            {{ $reportDetails['reportTitle'] }}
                                        </a>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['countryOffice'] }}</a></td>
                                    <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['dateCreated'] }}</a></td>
                                    <td class="border border-gray-200 px-4 py-2"><a href="">{{ $reportDetails['createdPerson'] }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
        <strong class="font-bold">Error:</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 close-button cursor-pointer">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M6.293 6.293a1 1 0 011.414 0L10 10.586l2.293-2.293a1 1 0 111.414 1.414L11.414 12l2.293 2.293a1 1 0 01-1.414 1.414L10 13.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 12 6.293 9.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </span>
    </div>
    @endif

    <footer class="home-footer mt-4 mx-auto">
        <p>&copy; <span id="currentYear">2023</span> United Nations Development Programme</p>
    </footer>

    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>

    <script>
        // Close the alert when the close button is clicked
        document.addEventListener('DOMContentLoaded', function () {
            const closeButtons = document.querySelectorAll('.close-button');

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.parentElement.style.display = 'none';
                });
            });
        });
    </script>

</x-app-layout>
