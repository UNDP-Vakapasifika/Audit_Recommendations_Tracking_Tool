@extends('layouts.master')

@section('body')
    <div x-data="{ showModal: false }">

        <div class="flex justify-between items-center">
            <h3 class="page-heading">Final Report Details</h3>
            @if (auth()->user()->isStakeholder())
                <button @click="showModal = true" class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
                    Start Conversation
                </button>
            @endif

        </div>

        <div class="py-4">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold mb-4">{{ $reportDetails[0]->audit_report_title }}</h2>

                            <a href="javascript:void(0);" onclick="history.back()"
                                class="font-semibold text-xl text-gray-800 leading-tight">Back</a>

                        </div>
                        <div style="overflow-x: auto;">
                            <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Audit Recommendations</th>
                                        <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                        <th class="border border-gray-200 px-4 py-2">Classification</th>
                                        <th class="border border-gray-200 px-4 py-2">Action Plan</th>
                                        <th class="border border-gray-200 px-4 py-2">Date of Audit</th>
                                        <th class="border border-gray-200 px-4 py-2">Target Completion Date</th>
                                        <th class="border border-gray-200 px-4 py-2">Follow Up Date</th>
                                        <th class="border border-gray-200 px-4 py-2">Responsible Person</th>
                                        <th class="border border-gray-200 px-4 py-2">Days Remaining|Overdue</th>
                                        <th class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 2;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportDetails as $statuschange)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->audit_recommendations }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->current_implementation_status }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->classification }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->action_plan }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->date_of_audit->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->target_completion_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->follow_up_date->format('d, M Y') }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $statuschange->responsible_person_name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @if ($statuschange->days_remaining >= 0)
                                                    {{ $statuschange->days_remaining }} days remaining
                                                @else
                                                    {{ abs($statuschange->days_remaining) }} days overdue
                                                @endif
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 1;">
                                                <a href="{{ route('status.edit', $statuschange->id) }}" class="text-blue-500 hover:underline">
                                                    <i class="fa fa-pencil"></i>{{ '  Make Changes' }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div x-show="showModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal  -->
                    <div x-show="showModal"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('messages.store') }}" method="post">
                            @csrf
                            <div class="p-6">
                                <div class="mb-4">
                                    <div class="w-full">
                                        <x-input-label for="message" class="text-lg" :value="__('Start the conversation')" />
                                        <x-textarea-input id="message" class="block mt-1 w-full" type="text"
                                            name="content" :value="old('content')" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                                        <input hidden type="text" name="final_report_id"
                                            value="{{ $reportDetails[0]->id }}" />
                                        <input hidden type="text" name="client_id"
                                            value="{{ $reportDetails[0]->client_id }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 items-center p-6 bg-gray-50">
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    @click="showModal = false">
                                    <i class="fa fa-times"></i> {{ __('Cancel') }}
                                </button>
                                <x-primary-button type="submit">
                                    <i class="fa fa-arrow-up"></i> {{ __('Message') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
