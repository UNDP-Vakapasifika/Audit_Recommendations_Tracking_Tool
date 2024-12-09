@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Action Plans</h3>
        <div class="flex gap-2">
            @if(auth()->user()->can('supervise action plan'))
                <x-primary-button class="bg-green-300">
                    <a href="{{ route('supervise') }}">
                        Supervise
                    </a>
                </x-primary-button>
            @endif

            @if(auth()->user()->can('create action plan'))
                <a href="{{ route('dynamicaction') }}"
                    class="btn-primary flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="">Action Plan</span>
                </a>
            @endif

            <!-- <form method="POST" action="{{ route('insertfinalreport') }}">
                @csrf
                <x-primary-button type="submit">
                    {{ __('Update Final Report') }}
                </x-primary-button>
            </form> -->
        </div>
    </div>

    <div class="flex flex-col mt-4">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full" id="example">
                    <thead>
                        <tr>
                            <th class="table-header">Audit Report Title</th>
                            <th class="table-header">Country Office</th>
                            <th class=table-header>Date Created</th>
                            <th class=table-header>Created Person</th>
                            <th class=table-header>View</th>

                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($uniqueReportDetails as $reportDetails)
                            <tr>
                                <td class="table-row-data">{{ $reportDetails['reportTitle'] }}</td>
                                <td class="table-row-data">{{ $reportDetails['countryOffice'] }}</td>
                                <td class="table-row-data">{{ $reportDetails['dateCreated'] }}</td>
                                <td class="table-row-data">{{ $reportDetails['createdPerson'] }}</td>

                                <td
                                    class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                    <a href="{{ route('action-plan.details', $reportDetails['id']) }}"
                                        class="text-blue-600 hover:text-blue-900">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-700"
                                    colspan="6">No plans yet.
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
        $(document).ready(function () {
            $('#example').DataTable({
                "lengthChange": false,
            });
        });
    </script>
@endsection

