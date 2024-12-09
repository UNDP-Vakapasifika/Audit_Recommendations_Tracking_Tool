<x-app-layout>
    @if(auth()->user()->can('upload recommendations'))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('Upload Audit Recommendations') }}
            </h2>
        </x-slot>
    @endif

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="table-filter">
                        <div class="flex justify-between items-center mt-2">
                            <form action="{{ route('upload.recommendations.post') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="file" name="excelDoc" id="excelDoc" class="form-control"
                                                   required
                                                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
                                        </div>
                                    </div>
                                    <x-primary-button class="mt-2">
                                        <i class="fa fa-arrow-up"></i> {{ __(' CSV File') }}
                                    </x-primary-button>
                                </div>
                            </form>
                            <x-primary-button>
                                <a href="{{ route('recommendations.create') }}">
                                    <i class="fa fa-plus"></i> {{ __('New Report') }}
                                </a>
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center text-bold">
                        <h2 class="text-2xl font-bold mb-4">Uploaded Recommendations</h2>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="w-full border border-gray-200"
                               style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Report Number</th>
                                <th>Report Title</th>
                                <th>Publication Date</th>
                                <!-- <th>page_par_reference</th> -->
                                <th>Recommendation</th>
                                <th>Client</th>
                                <!-- <th>additional_body</th> -->
                                <!-- <th>sector</th> -->
                                <th>Key Issues</th>
                                <th>Acceptance Status</th>
                                <th>Implementation Status</th>
                                <th>Repeated Finding</th>
                                <th>Follow Up Date</th>
                                <!-- <th>responsible_entity</th> -->
                                <!-- <th>summary_of_responce</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <!-- <td>{{ $row->id }}</td> -->
                                    <td>{{ $row->report_numbers }}</td>
                                    <td>{{ $row->report_title }}</td>
                                    <td>{{ $row->publication_date }}</td>
                                    <!-- <td>{{ $row->page_par_reference }}</td> -->
                                    <td>{{ $row->recommendation }}</td>
                                    <td>{{ $row->client }}</td>
                                    <!-- <td>{{ $row->additional_body }}</td> -->
                                    <!-- <td>{{ $row->sector }}</td> -->
                                    <td>{{ $row->key_issues }}</td>
                                    <td>{{ $row->acceptance_status }}</td>
                                    <td>{{ $row->implementation_status }}</td>
                                    <td>{{ $row->recurence }}</td>
                                    <td>{{ $row->follow_up_date }}</td>
                                    <!-- <td>{{ $row->responsible_entity }}</td> -->
                                    <!-- <td>{{ $row->summary_of_responce }}</td> -->

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="home-footer mt-4 mx-auto">
        <p>&copy; <span id="currentYear">2023</span> United Nations Development Programme</p>
    </footer>

    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>

    <script>
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
