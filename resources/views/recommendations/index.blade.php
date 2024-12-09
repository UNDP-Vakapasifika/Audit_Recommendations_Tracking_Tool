@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">All Recommendations</h3>
        @if (auth()->user()->can('upload recommendations'))
            <a href="{{ route('recommendations.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500">Add Recommendation</a>
        @endif
    </div>

    <div class="flex flex-col mt-4">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full" id="example">
                    <thead>
                        <tr>
                            <th class="table-header">Report Title</th>
                            <th class="table-header">Audit Type</th>
                            <th class="table-header">Publication Date</th>
                            <th class="table-header">Client</th>
                            <th class="table-header">Responsible Entity</th>
                            <th class="table-header">Number of Recommendations</th>
                            <th class="table-header">Action</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($recommendations as $recommendation)
                            <tr>
                                <td class="table-row-data">{{ Str::limit($recommendation->report_title, 30, '...') }}</td>
                                <td class="table-row-data">{{ $recommendation->audit_type }}</td>
                                <td class="table-row-data">{{ $recommendation->publication_date->format('Y-m-d') }}</td>
                                <td class="table-row-data">{{ $recommendation->client }}</td>
                                <td class="table-row-data">{{ $recommendation->responsible_entity }}</td>
                                <td class="table-row-data">{{ $recommendation->recommendation_count }}</td>
                                <td class="table-row-data">
                                    <a href="{{ route('recommendations.details', ['report_title' => $recommendation->report_title]) }}"
                                        class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-700"
                                    colspan="7">No recommendations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({

                "columnDefs": [{
                    "orderable": false,
                    "targets": 5
                }],

                "lengthChange": false,
            });
        });
    </script>
@endsection
