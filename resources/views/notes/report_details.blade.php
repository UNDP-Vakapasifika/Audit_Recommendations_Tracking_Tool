@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Final Report Notes</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4">{{ $reportDetails[0]->audit_report_title }}</h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <div class="overflow-x-auto whitespace-nowrap">
                        <table class="w-full border border-gray-200 table-fixed">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Client Type</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Recommendations</th>
                                    <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                    <th class="border border-gray-200 px-4 py-2">Remaining|Overdue Days</th>
                                    <th class="border border-gray-200 px-4 py-2">Target Completion Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Reason Not Implemented</th>
                                    @if(auth()->user()->can('create final report cautions'))
                                        <th class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 2;">Comment</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportDetails as $details)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->client_type_name }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ Str::limit($details->audit_recommendations, 40) }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->current_implementation_status }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            @if($details->days_remaining >= 0)
                                                {{ $details->days_remaining }} days remaining
                                            @else
                                                {{ abs($details->days_remaining) }} days overdue
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->target_completion_date->format('d, M Y') }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $details->reason_not_implemented }}</td>
                                        @if(auth()->user()->can('create final report cautions'))
                                            <td class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 1;">
                                                <a href="{{ route('notes.recom.details', $details->id) }}" class="text-blue-500">
                                                    Notes <span class="badge">({{ $details->notes_count }})</span>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
