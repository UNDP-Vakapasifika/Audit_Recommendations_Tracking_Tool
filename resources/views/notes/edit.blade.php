@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">FinalReport Details : {{ $finalReport->audit_report_title }}</h3>
        <!-- <a href="javascript:void(0);" onclick="history.back()" class=" leading-tight"><- Back</a> -->
        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>

    </div>

    <div class="flex flex-col mt-4" x-data="{ showModal: false }">
        <div class="page-subheading">{{ $finalReport->report_title }}</div>
        <div class="bg-white shadow-md rounded-md overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex flex-wrap gap-4 md:gap-6">
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Audit Recommendations</span>
                        <span class="text-gray-600">{{ $finalReport->audit_recommendations }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Key Issues</span>
                        <span class="text-gray-600">{{ $finalReport->key_issues }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-semibold">Audit Type</span>
                        <span class="text-gray-600">{{ $finalReport->audit_type }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Status</span>
                        <span class="text-gray-600">{{ $finalReport->current_implementation_status }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Classification</span>
                        <span class="text-gray-600">{{ $finalReport->classification }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Audit Date</span>
                        <span class="text-gray-600">{{ $finalReport->date_of_audit->format('d, M Y') }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Publication Date</span>
                        <span class="text-gray-600">{{ $finalReport->publication_date->format('d, M Y') }}</span>
                    </div>

                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Action Plan</span>
                        <span class="text-gray-600">{{ $finalReport->action_plan }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Client Summary of Response</span>
                        <span class="text-gray-600">{{ $finalReport->summary_of_response }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">SAI Responsible Person</span>
                        <span class="text-gray-600">{{ $finalReport->responsible_person }}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0 w-fit">
                        <span class="text-gray-700 font-bold">Audit Team Lead</span>
                        <span class="text-gray-600">{{ $finalReport->audit_team_lead }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->can('see final report cautions'))
        <div class="bg-white shadow-md rounded-md overflow-hidden mt-4">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="page-subheading">Notes</h3>
                    <div>
                        <!-- Button to open the modal -->
                        @if (auth()->user()->can('add final report cautions'))
                            <x-primary-button @click="showModal = true">
                                <i class="fa fa-arrow-up"></i> {{ __('Comment') }}
                            </x-primary-button>
                        @endif
                    </div>
                </div>

                <div class="mt-4" id="caution">
                    <div style="overflow-x: auto;">
                        <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">By</th>
                                    <th class="border border-gray-200 px-4 py-2">Title</th>
                                    <th class="border border-gray-200 px-4 py-2">Message</th>
                                    <th class="border border-gray-200 px-4 py-2">Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($finalReport->notes as $note)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ $note->user->name }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $note->title }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $note->content }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $note->created_at->format('d, M Y') }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            @if (auth()->user()->can('delete final report cautions'))
                                                <form class="delete_item" action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Delete Record" data-toggle="tooltip" class="text-red-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2" colspan="5">No Notes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        @endif

        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="showModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div x-show="showModal"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('final-report.notes.store', $finalReport->id) }}" method="post">
                        @csrf
                        <div class="w-full px-4 pt-4">
                            <x-input-label for="title" :value="__('Note Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />

                            <x-input-label for="content" :value="__('Note Content')" class="mt-4" />
                            <x-textarea-input id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                        <div class="flex justify-between items-center p-4 bg-gray-50">
                            <x-secondary-button class="bg-grey" onclick="cancelAndReload(event)">
                                <i class="fa fa-times"></i> {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button type="submit">
                                <i class="fa fa-arrow-up"></i> {{ __('Save') }}
                            </x-primary-button>

                            <script>
                                function cancelAndReload(event) {
                                    event.preventDefault();
                                    location.reload();
                                }
                            </script>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
