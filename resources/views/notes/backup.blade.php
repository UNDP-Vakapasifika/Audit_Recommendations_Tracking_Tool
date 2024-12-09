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
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Reply to Note</h3>
                            <div class="mt-2">
                                <form :action="`/notes/${noteIdForReply}/replies`" method="POST" id="replyForm">
                                    @csrf
                                    <div class="mb-4">
                                        <x-input-label for="reply_message" :value="__('Reply Message')" />
                                        <x-textarea-input id="reply_message" class="block mt-1 w-full" type="text" name="reply_message" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('reply_message')" />
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reply</button>
                                        <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="showReplyModal = false">Cancel</button>
                                    </div>
                                </form>
                                <div class="mt-4">
                                    <h4 class="text-lg font-medium text-gray-900">Existing Replies</h4>
                                    <div x-show="noteToShow.replies.length > 0">
                                        <template x-for="reply in noteToShow.replies" :key="reply.id">
                                            <div class="bg-gray-100 p-2 mt-2 rounded">
                                                <p><strong x-text="reply.user.name"></strong> (<span x-text="new Date(reply.created_at).toLocaleDateString()"></span>): <span x-text="reply.reply_message"></span></p>
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