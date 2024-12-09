@extends('layouts.master')

@section('body')
<div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
    <h3 class="page-heading">FinalReport Details : {{ $finalReport->audit_report_title }}</h3>
    <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
</div>

<div class="flex flex-col mt-4" x-data="noteComponent" x-init="initialize()">
    <div class="page-subheading">{{ $finalReport->report_title }}</div>
    <div class="bg-white shadow-md rounded-md overflow-hidden">
        <div class="px-6 py-4">
            <div class="flex flex-wrap gap-4 md:gap-6">
                <!-- Final report details -->
                @foreach ([
                    'Audit Recommendations' => $finalReport->audit_recommendations,
                    'Key Issues' => $finalReport->key_issues,
                    'Audit Type' => $finalReport->audit_type,
                    'Status' => $finalReport->current_implementation_status,
                    'Classification' => $finalReport->classification,
                    'Audit Date' => $finalReport->date_of_audit->format('d, M Y'),
                    'Publication Date' => $finalReport->publication_date->format('d, M Y'),
                    'Action Plan' => $finalReport->action_plan,
                    'Client Summary of Response' => $finalReport->summary_of_response,
                    'SAI Responsible Person' => $finalReport->responsible_person,
                    'Audit Team Lead' => $finalReport->audit_team_lead
                ] as $label => $value)
                <div class="flex flex-col mt-2 md:mt-0 w-fit">
                    <span class="text-gray-700 font-bold">{{ $label }}</span>
                    <span class="text-gray-600">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(auth()->user()->can('see final report cautions'))
    <div class="bg-white shadow-md rounded-md overflow-hidden mt-4">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="page-subheading">Notes</h3>
                <div>
                    @if (auth()->user()->can('add final report cautions'))
                        <x-primary-button @click="showModal = true; isEdit = false; noteTitle = ''; noteContent = '';">
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
                                <th class="border border-gray-200 px-4 py-2">Replies</th>
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
                                        <button 
                                            @click="showReplyModal = true; noteIdForReply = {{ $note->id }}; noteToShow = {{ $note->toJson() }};" 
                                            class="text-blue-500"
                                        >
                                            Reply ({{ $note->replies->count() }})
                                        </button>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="text-blue-500" @click="showModal = true; isEdit = true; noteId = {{ $note->id }}; noteTitle = '{{ $note->title }}'; noteContent = '{{ $note->content }}'">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 3.487c.348-.35.768-.643 1.238-.862a3.093 3.093 0 0 1 4.013 4.013c-.219.47-.512.89-.862 1.238l-11.016 11.016a4.5 4.5 0 0 1-1.597 1.038l-3.387 1.128a.75.75 0 0 1-.948-.948l1.128-3.387a4.5 4.5 0 0 1 1.038-1.597L16.862 3.487zM19.36 2.64a1.593 1.593 0 1 0 2.25 2.25 1.593 1.593 0 0 0-2.25-2.25zM12 16.5l3 3M9 21h7.5" />
                                                </svg>
                                            </button>
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2" colspan="6">No Notes</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Note Modal -->
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
                <form :action="isEdit ? `/notes/${noteId}` : `{{ route('final-report.notes.store', $finalReport->id) }}`" method="post">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div class="w-full px-4 pt-4">
                        <x-input-label for="title" :value="__('Note Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" x-model="noteTitle" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />

                        <x-input-label for="content" :value="__('Note Message')" />
                        <x-textarea-input id="content" class="block mt-1 w-full" type="text" name="content" x-model="noteContent" required />
                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50">
                        <x-secondary-button class="bg-grey" @click="showModal = false">
                            <i class="fa fa-times"></i> {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-primary-button type="submit">
                            <i class="fa fa-arrow-up"></i> {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div x-show="showReplyModal" class="fixed inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showReplyModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- Modal content -->
            <div x-show="showReplyModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" @click.away="showReplyModal = false">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <!-- <h3 class="text-lg leading-6 font-medium text-gray-900">Reply to Note</h3> -->
                            <div class="mt-2 text-left">
                                <!-- Display the note being replied to -->
                                <div class="mb-4 p-2 border rounded bg-gray-100 overflow-auto max-h-32">
                                    <p class="font-semibold">Note:</p>
                                    <p x-text="noteToShow.content"></p>
                                </div>
                                <!-- Reply form -->
                                <form :action="`/notes/${noteIdForReply}/replies`" method="POST" id="replyForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="replyContent" class="block text-gray-700 text-sm font-bold mb-2">Reply</label>
                                        <textarea id="replyContent" name="reply_message" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" x-model="replyContent" rows="3"></textarea>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reply</button>
                                        <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="showReplyModal = false">Cancel</button>
                                    </div>
                                </form>
                                <!-- Existing replies -->
                                <div class="mt-4">
                                    <h4 class="text-lg font-medium text-gray-900">Existing Replies</h4>
                                    <div x-show="noteToShow.replies.length > 0" class="overflow-auto max-h-32">
                                        <template x-for="reply in noteToShow.replies" :key="reply.id">
                                            <div class="bg-gray-100 p-2 mt-2 rounded break-words">
                                                <p><strong>By </strong><strong x-text="reply.user.name"></strong> (<span x-text="new Date(reply.created_at).toLocaleDateString()"></span>):</p>
                                                <p class="break-all"><span x-text="reply.reply_message"></span></p>
                                            </div>
                                        </template>
                                    </div>
                                    <div x-show="noteToShow.replies.length === 0">
                                        <p>No replies yet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@section('scripts')
<script>
    function noteComponent() {
        return {
            showModal: false,
            showReplyModal: false,
            isEdit: false,
            noteId: null,
            noteTitle: '',
            noteContent: '',
            noteIdForReply: null,
            replyContent: '',
            noteToShow: {},

            initialize() {
                // Initialize any required data or state
            }
        }
    }
</script>
@endsection
@endsection
