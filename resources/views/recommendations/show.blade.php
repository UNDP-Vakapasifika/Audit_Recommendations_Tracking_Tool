@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center mb-4">
        <h3 class="page-heading">Recommendations Details for Report: {{ $firstRecommendation->report_title }}</h3>
        <div class="flex md:flex-row justify-start md:justify-between md:items-center gap-2">
            @if (auth()->user()->can('upload recommendations'))
                <a href="{{ route('recommendations.create') }}"
                    class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Add New Recommendation
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white shadow-md rounded-md overflow-hidden">
        <div class="px-6 py-4">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="table-header">Report #</th>
                        <th class="table-header">Recommendation</th>
                        <th class="table-header">Key Issues</th>
                        <th class="table-header">Repeated Finding</th>
                        <th class="table-header">Sector</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Client</th>
                        <th class="table-header">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @forelse($recommendations as $rec)
                        <tr>
                            <td class="table-row-data">{{ $rec->report_numbers }}</td>
                            <td class="table-row-data">{{ Str::limit($rec->recommendation, 30, '...') }}</td>
                            <td class="table-row-data">{{ $rec->key_issues }}</td>
                            <td class="table-row-data">{{ $rec->recurence }}</td>
                            <td class="table-row-data">{{ $rec->sector }}</td>
                            <td class="table-row-data">{{ $rec->implementation_status }}</td>
                            <td class="table-row-data">{{ $rec->client }}</td>
                            <td class="table-row-data">
                                @if (auth()->user()->can('edit recommendations'))
                                    <a href="{{ route('recommendations.edit', $rec->id) }}"
                                        class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                                        Edit
                                    </a>
                                @endif
                                @if (auth()->user()->can('delete recommendations'))
                                    <form class="inline-block" action="{{ route('recommendations.delete', $rec->id) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this recommendation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-700"
                                colspan="8">No recommendations found for this report.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
