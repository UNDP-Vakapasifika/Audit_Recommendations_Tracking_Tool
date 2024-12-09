@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Create Action Plan</h3>
    </div>

    <div class="max-w-7xl mx-auto pt-6 ">
        <x-validation-errors class="mb-4" :errors="$errors" />

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-between items-center p-3">
                <h2 class="text-2xl font-bold mb-4"></h2>
                <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
            </div>

            <form method="POST" action="{{ route('action-plans.store') }}">
                @csrf
                <div class="p-4">
                    <div class="flex flex-wrap gap-y-3 gap-x-0">
                        <!-- Dynamic Part: Audit Report Title -->
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                            <x-input-label for="audit_report_title">{{ __('Choose Report Title') }}</x-input-label>
                            <x-select-input id="audit_report_title" class="block mt-1 w-full" type="text"
                                name="audit_report_title" :value="old('audit_report_title')" required>
                                <option value="">-- Select an option --</option>
                                @foreach ($auditTitles as $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('current_implementation_status')" />
                        </div>

                        <!-- Gender Mainstream Type -->
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                            <x-input-label for="gender_mainstream_type" :value="__('Gender Mainstream Type')" />
                            <x-select-input id="gender_mainstream_type" class="block mt-1 w-full" type="text"
                                name="gender_mainstream_type" :value="old('gender_mainstream_type')">
                                <option value="">-- Select an option --</option>
                                @foreach ($genderMainstreamTypes as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-select-input>
                        </div>

                        <!-- Country Office -->
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                            <x-input-label for="country_office" :value="__('Country Office')" />
                            <x-select-input id="country_office" class="block mt-1 w-full" type="text"
                                name="country_office" :value="old('country_office')" required>
                                <option value="">-- Select an option --</option>
                                @foreach ($countryOffices as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-select-input>
                        </div>

                        <!-- Date of Audit -->
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                            <x-input-label for="date_of_audit" :value="__('Date of Audit')" />
                            <x-text-input id="date_of_audit" class="block mt-1 w-full" type="date" name="date_of_audit"
                                :value="old('date_of_audit')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_of_audit')" />
                        </div>

                        <!-- Head of Audited Entity -->
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                            <x-input-label for="head_of_audited_entity" :value="__('Head of Audited Entity Name')" />
                            <x-select-input id="head_of_audited_entity" class="block mt-1 w-full" type="text"
                                name="head_of_audited_entity" :value="old('head_of_audited_entity')" required>
                                <option value="">-- Select an option --</option>
                                @foreach ($headOfEntities as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('head_of_audited_entity')" />
                        </div>

                        <!-- Audited Entity Focal Point -->
                        <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                            <x-input-label for="audited_entity_focal_point" :value="__('Audited Entity Focal Point')" />
                            <x-select-input id="audited_entity_focal_point" class="block mt-1 w-full" type="text"
                                name="audited_entity_focal_point" :value="old('audited_entity_focal_point')" required>
                                <option value="">-- Select an option --</option>
                                @foreach ($focalPoint as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('audited_entity_focal_point')" />
                        </div>


                        <!-- Audit Team Leader -->
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="audit_team_lead" :value="__('Audit Team Leader')" />
                            <x-select-input id="audit_team_lead" class="block mt-1 w-full" type="text"
                                name="audit_team_lead" :value="old('audit_team_lead')" required>
                                <option value="">-- Select an option --</option>
                                @foreach ($team_Leader as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('audit_team_lead')" />
                        </div>

                        <!-- Responsible Person/Internal Auditor -->
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="responsible_person" :value="__('Responsible Person/Internal Auditor')" />
                            <x-select-input id="responsible_person" class="block mt-1 w-full" type="text"
                                name="responsible_person" :value="old('responsible_person')" required>
                                <option value="">-- Select an option --</option>
                                @foreach ($responsible_person as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('responsible_person')" />
                        </div>

                        <!-- Dynamic Recommendations Table -->
                        <div class="w-full">
                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr>
                                                <th class="table-header">Audit Report Title</th>
                                                <th class="table-header">Implementation Status</th>
                                                <th class="table-header">Classification</th>
                                                <th class="table-header">Action Plan</th>
                                                <th class="table-header">Target Completion Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic_recommendations">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(auth()->user()->can('create action plan'))
                        <div class="flex justify-end  mt-4">
                            <x-primary-button>
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reportTitleSelect = document.getElementById('audit_report_title');
            const dynamicRecommendationsTable = document.getElementById('dynamic_recommendations');

            reportTitleSelect.addEventListener('change', function() {
                const selectedTitle = reportTitleSelect.value;

                fetch('/get-recommendations/' + selectedTitle)
                    .then(response => response.json())
                    .then(recommendations => {
                        dynamicRecommendationsTable.innerHTML = '';

                        recommendations.forEach(recommendation => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="border border-gray-200 px-4 py-2">
                                    <textarea name="audit_recommendations[]" class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" readonly>${recommendation.recommendation}</textarea>
                                    <input type="hidden" name="recommendation_ids[]" value="${recommendation.id}">
                                </td>
                                <td class="border border-gray-200 px-4 py-2 align-top">
                                    <select name="current_implementation_status[]" 
                                            class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" 
                                            required>
                                        <option value="" disabled selected>Choose Status...</option>
                                        <option value="Fully Implemented">Fully Implemented</option>
                                        <option value="Not Implemented">Not Implemented</option>
                                        <option value="Partially Implemented">Partially Implemented</option>
                                        <option value="No Update">No Update</option>
                                        <option value="No Longer Applicable">No Longer Applicable</option>
                                    </select>
                                </td>
                                <td class="border border-gray-200 px-4 py-2 align-top">
                                    <select name="classification[]" 
                                            class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" 
                                            required>
                                        <option value="" disabled selected>Choose Level..</option>
                                        <option value="Critical">Critical</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </td>
                                <td class="border border-gray-200 px-4 py-2 align-top">
                                    <textarea name="action_plan[]" 
                                            class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline resize-none" 
                                            required rows="3"></textarea>
                                </td>
                                <td class="border border-gray-200 px-4 py-2 align-top">
                                    <input type="date" name="target_completion_date[]" 
                                        class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline target-completion-date" 
                                        required>
                                    <span class="text-red-500 text-xs mt-1 hidden">Please select a valid date.</span>
                                </td>
                            `;
                            dynamicRecommendationsTable.appendChild(row);
                        });

                        // Validate form to ensure "Choose Status..." is not selected
                        const form = document.querySelector('form');
                        form.addEventListener('submit', function(event) {
                            const statusSelects = document.querySelectorAll('select[name="current_implementation_status[]"]');
                            const classificationSelects = document.querySelectorAll('select[name="classification[]"]');

                            for (const select of statusSelects) {
                                if (select.value === "") {
                                    event.preventDefault();
                                    alert('Please select a valid status for all recommendations.');
                                    return;
                                }
                            }

                            for (const select of classificationSelects) {
                                if (select.value === "") {
                                    event.preventDefault();
                                    alert('Please select a valid classification for all recommendations.');
                                    return;
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching recommendations:', error);
                    });
            });
        });
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            // Attach event listener for Date of Audit
            document.getElementById('date_of_audit').addEventListener('input', function() {
                validateDate(this);
            });

            // Attach event listener for Target Completion Dates
            document.querySelectorAll('.target-completion-date').forEach(function(input) {
                input.addEventListener('input', function() {
                    validateDate(this);
                });
            });

            function validateDate(inputElement) {
                const errorSpan = inputElement.nextElementSibling;

                if (errorSpan && errorSpan.classList.contains('text-red-500')) {
                    const currentDate = new Date();
                    const selectedDate = new Date(inputElement.value);

                    // Check the relationship between input and error span
                    if (inputElement.id === 'date_of_audit') {
                        // Validation for Date of Audit (in the past)
                        if (selectedDate > currentDate) {
                            errorSpan.classList.remove('hidden');
                            inputElement.setCustomValidity('Please select a date in the past.');
                        } else {
                            errorSpan.classList.add('hidden');
                            inputElement.setCustomValidity('');
                        }
                    } else {
                        // Validation for Target Completion Date (in the future)
                        if (selectedDate <= currentDate) {
                            errorSpan.classList.remove('hidden');
                            inputElement.setCustomValidity('Please select a date in the future.');
                        } else {
                            errorSpan.classList.add('hidden');
                            inputElement.setCustomValidity('');
                        }
                    }
                }
            }
        });
    </script>
@endsection
