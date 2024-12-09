@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        {{ isset($recommendation) ? 'Edit Recommendation' : 'Add Recommendation' }}
    </h3>
    @if (!isset($recommendation))
        <p class="pt-1 text-gray-800">You can click on the button below to upload a CSV file or fill in the Recommendations
            details below</p>

        <div class="max-w-7xl mx-auto pt-6 ">
            <h3 class="page-subheading">Upload CSV</h3>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="post" action="{{ route('recommendations.upload.csv') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 flex justify-between">
                        <div>

                            <input type="file" name="excelDoc"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                class="block w-full text-sm text-slate-500 mt-1
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100
                                cursor-pointer"
                                required />

                            <x-input-error class="mt-2" :messages="$errors->get('excelDoc')" />
                        </div>
                        @if (auth()->user()->can('upload recommendations'))
                            <div>
                                <x-primary-button>
                                    {{ __('Upload CSV') }}
                                </x-primary-button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto pt-6 ">
        @if (!isset($recommendation))
            <h3 class="page-subheading">Add Recommendation</h3>
        @endif

        <x-validation-errors class="mb-4" :errors="$errors" />

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form method="post"
                action="{{ isset($recommendation) ? route('recommendations.update', $recommendation->id) : route('recommendations.store') }}">
                @csrf

                @if (isset($recommendation))
                    @method('PUT')
                @endif
                <div class="p-4">
                    <div class="flex flex-wrap gap-y-3 gap-x-0">
                        <div class="w-full">
                            <x-input-label for="report_title" :value="__('Report Title')" />
                            <x-text-input id="report_title" class="block mt-1 w-full" type="text" name="report_title"
                                :value="isset($recommendation) ? $recommendation->report_title : old('report_title')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('report_title')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="report_numbers" :value="__('Report Number')" />
                            <x-text-input id="report_numbers" class="block mt-1 w-full" type="text" name="report_numbers"
                                :value="isset($recommendation)
                                    ? $recommendation->report_numbers
                                    : old('report_numbers')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('report_numbers')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="publication_date" :value="__('Publication Date')" />
                            <x-text-input id="publication_date" class="block mt-1 w-full" type="date"
                                name="publication_date" :value="isset($recommendation)
                                    ? $recommendation->publication_date
                                    : old('publication_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('publication_date')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="client" :value="__('Client')" />

                            <select id="client" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" name="client" >
                                <option value="">-- Select an option --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @if (isset($recommendation) && $recommendation->client === $client->id) selected @endif>
                                        {{ $client->name }}</option>
                                @endforeach
                                </select>

                            <x-input-error class="mt-2" :messages="$errors->get('acceptance_status')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="sector" :value="__('Sector')" />
                            <x-text-input id="sector" class="block mt-1 w-full" type="text" name="sector"
                                :value="isset($recommendation) ? $recommendation->sector : old('sector')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('sector')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="recurrence" :value="__('Recurrence')" />
                            <x-select-input id="recurence" class="block mt-1 w-full" type="text" name="recurence"
                                :value="old('recurence')" required>
                                <option value="">-- Select an option --</option>
                                <option value="Yes" @if (isset($recommendation) && $recommendation->recurence === 'Yes') selected @endif>Yes</option>
                                <option value="No" @if (isset($recommendation) && $recommendation->recurence === 'No') selected @endif>No</option>
                                <!-- <option value="Ad Hoc" @if (isset($recommendation) && $recommendation->recurence === 'Ad Hoc') selected @endif>Biennal</option> -->
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('recurence')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="acceptance_status" :value="__('Acceptance Status')" />
                            <x-select-input id="acceptance_status" class="block mt-1 w-full" type="text"
                                name="acceptance_status" :value="old('acceptance_status')" required>
                                <option value="">-- Select an option --</option>
                                <option value="Accepted" @if (isset($recommendation) && $recommendation->acceptance_status === 'Accepted') selected @endif>Accepted</option>
                                <option value="Denied" @if (isset($recommendation) && $recommendation->acceptance_status === 'Denied') selected @endif>Denied</option>
                            </x-select-input>

                            <x-input-error class="mt-2" :messages="$errors->get('acceptance_status')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="implementation_status" :value="__('Implementation Status')" />
                            <x-select-input id="implementation_status" class="block mt-1 w-full" type="text"
                                name="implementation_status" :value="old('implementation_status')" required>
                                <option value="">-- Select an option --</option>
                                <option value="Full Implemented" @if (isset($recommendation) && $recommendation->implementation_status === 'Fully Implemented') selected @endif>Fully
                                    Implemented</option>
                                <option value="Partially Implemented" @if (isset($recommendation) && $recommendation->implementation_status === 'Partially Implemented') selected @endif>
                                    Partially Implemented</option>
                                <option value="Not Implemented" @if (isset($recommendation) && $recommendation->implementation_status === 'Not Implemented') selected @endif>Not
                                    Implemented</option>
                                <option value='No Update' @if (isset($recommendation) && $recommendation->implementation_status === 'No Update') selected @endif>No Update
                                </option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('implementation_status')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="sai_confirmation" :value="__('SAI Confirmation')" />
                            <x-select-input id="sai_confirmation" class="block mt-1 w-full" type="text"
                                name="sai_confirmation" :value="old('sai_confirmation')" required>
                                <option value="">-- Select an option --</option>
                                <option value="Yes" @if (isset($recommendation) && $recommendation->sai_confirmation === 'Yes') selected @endif>Yes</option>
                                <option value="No" @if (isset($recommendation) && $recommendation->sai_confirmation === 'No') selected @endif>No</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('sai_confirmation')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="audit_type" :value="__('Audit Type')" />
                            <x-select-input id="audit_type" class="block mt-1 w-full" type="text" name="audit_type"
                                :value="old('audit_type')" required>
                                <option value="">-- Select an option --</option>

                                <option value="Performance" @if (isset($recommendation) && $recommendation->audit_type === 'Performance') selected @endif>
                                    Performance
                                </option>
                                <option value="Compliance" @if (isset($recommendation) && $recommendation->audit_type === 'Compliance') selected @endif>
                                    Compliance
                                </option>
                                <option value="Investigative" @if (isset($recommendation) && $recommendation->audit_type === 'Financial') selected @endif>
                                    Financial
                                </option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('audit_type')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="actual_expected_imp_date" :value="__('Actual Expected Implementation Date')" />
                            <x-text-input id="actual_expected_imp_date" class="block mt-1 w-full" type="date"
                                name="actual_expected_imp_date" :value="isset($recommendation)
                                    ? $recommendation->actual_expected_imp_date
                                    : old('actual_expected_imp_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('actual_expected_imp_date')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="follow_up_date" :value="__('Follow-up Date')" />
                            <x-text-input id="follow_up_date" class="block mt-1 w-full" type="date"
                                name="follow_up_date" :value="isset($recommendation)
                                    ? $recommendation->follow_up_date
                                    : old('follow_up_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('follow_up_date')" />
                        </div>

                        <div class="w-full md:w-1/3">
                            <x-input-label for="responsible_entity" :value="__('Responsible Entity')" />
                            <x-text-input id="responsible_entity" class="block mt-1 w-full" type="text"
                                name="responsible_entity" :value="isset($recommendation)
                                    ? $recommendation->responsible_entity
                                    : old('responsible_entity')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('responsible_entity')" />
                        </div>

                        <div class="w-full md:w-1/3">
                            <x-input-label for="page_par_reference" :value="__('Page Par Reference')" />
                            <x-text-input id="page_par_reference" class="block mt-1 w-full" type="text"
                                name="page_par_reference" :value="isset($recommendation)
                                    ? $recommendation->page_par_reference
                                    : old('page_par_reference')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('page_par_reference')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="summary_of_response" :value="__('Summary of Response')" />
                            <x-textarea-input id="summary_of_response" class="block mt-1 w-full" type="text"
                                name="summary_of_response" :value="isset($recommendation)
                                    ? $recommendation->summary_of_response
                                    : old('summary_of_response')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('summary_of_response')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="recommendation" :value="__('Recommendation')" />
                            <x-textarea-input id="recommendation" class="block mt-1 w-full" type="text"
                                name="recommendation" :value="isset($recommendation)
                                    ? $recommendation->recommendation
                                    : old('recommendation')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('recommendation')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="key_issues" :value="__('Key Issues')" />
                            <x-textarea-input id="key_issues" class="block mt-1 w-full" type="text" name="key_issues"
                                :value="isset($recommendation) ? $recommendation->key_issues : old('key_issues')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('key_issues')" />
                        </div>
                    </div>

                    @if (auth()->user()->can('upload recommendations'))
                        <div class="flex justify-end mt-4">
                            <x-primary-button>
                                {{ isset($recommendation) ? 'Update Recommendation' : 'Add Recommendation' }}
                            </x-primary-button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
