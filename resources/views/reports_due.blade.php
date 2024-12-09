@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">All Reports due on {{request()->query('date')}}</h3>   
    </div>

    <div class="max-w-7xl mx-auto pt-4 ">
        
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full" id="reports">
                        <thead>
                            <tr>
                                <th class="table-header">Country Office</th>
                                <th class="table-header">Report Title</th>
                                <th class=table-header>Audit Date</th>
                                <th class=table-header>Repeated Finding</th>
                                <th class=table-header>Responsible Person</th>
                                <th class=table-header>Status</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @forelse($reportsDueOnTheDate as $report)
                                <tr>
                                    <td class="table-row-data">{{ $report->country_office }}</td>
                                    <td class="table-row-data">
                                        {{ Str::limit($report->audit_report_title, 20, '...') }}</td>
                                    <td class="table-row-data">{{ $report->date_of_audit }}</td>
                                    <td class="table-row-data">{{ Str::limit($report->recurence, 15, '...') }}</td>
                                    <td class="table-row-data">{{ $report->responsible_person }}</td>
                                    <td class="table-row-data">{{ $report->current_implementation_status }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                        <a href="{{route('final.report.details', $report->id)}}" class="text-blue-600 hover:text-blue-900">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-700"
                                        colspan="6">No reports found due on {{request()->query('date')}}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

