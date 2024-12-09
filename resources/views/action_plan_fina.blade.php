@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Create Action Plan</h3>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 close-button cursor-pointer">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M6.293 6.293a1 1 0 011.414 0L10 10.586l2.293-2.293a1 1 0 111.414 1.414L11.414 12l2.293 2.293a1 1 0 01-1.414 1.414L10 13.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 12 6.293 9.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </span>
        </div>
    @endif

    <div class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4"></h2>
                        <a href="javascript:void(0);" onclick="history.back()"
                            class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <form method="POST" action="{{ route('action-plans.store') }}">
                        @csrf
                        <div class="mb-4 ">
                            <label for="audit_report_title" class="block text-sm font-medium text-gray-600">Choose Report
                                Title</label>
                            <select id="audit_report_title" name="audit_report_title"
                                class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="---">---</option>
                                @foreach ($auditTitles as $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('audit_report_title')" class="mt-2" />
                        </div>
                        <!-- Static Part: Audit Stakeholder Information -->
                        <div class="mb-4">
                            <!-- Country Office -->
                            <div class="flex space-x-4">
                                <div class="mb-4 flex-1">
                                    <x-input-label for="country_office" :value="__('Department')" />
                                    <select id="country_office" name="country_office"
                                        class="block mt-1 border w-3/4 rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="---">---</option>
                                        @foreach ($countryOffices as $office)
                                            <option value="{{ $office }}">{{ $office }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('country_office')" class="mt-2" />
                                </div>
                                <!-- Date of audit -->
                                <div class="mb-4 flex-1">
                                    <label for="date_of_audit" class="block text-sm font-medium text-gray-600">Date of
                                        Audit</label>
                                    <input type="date" name="date_of_audit" id="date_of_audit"
                                        class="block mt-1 border rounded-md w-3/4 py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <span id="date-error" class="text-red-500 text-xs mt-1 hidden">Please select a date in
                                        the past.</span>
                                </div>
                                <!-- Head of Audited Entity Name -->
                                <div class=" flex-1">
                                    <x-input-label for="head_of_audited_entity" :value="__('Head of Audited Entity Name')" />
                                    <select id="head_of_audited_entity" name="head_of_audited_entity"
                                        class="block mt-1  border w-3/4 rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="---">---</option>
                                        @foreach ($headOfEntities as $head)
                                            <option value="{{ $head }}">{{ $head }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('head_of_audited_entity')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex space-x-4">
                                <!-- Name of Audited Entity Focal Point -->
                                <div class="mb-4 flex-1">
                                    <x-input-label for="audited_entity_focal_point" :value="__('Audited Entity Focal Point')" />
                                    <select id="audited_entity_focal_point" name="audited_entity_focal_point"
                                        class="block mt-2 border w-3/4 rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="---">---</option>
                                        @foreach ($focalPoint as $focal)
                                            <option value="{{ $focal }}">{{ $focal }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('audited_entity_focal_point')" class="mt-2" />
                                </div>

                                <!-- Name of Audit Team Lead from AUDIT OFFICE -->
                                <div class="mb-4 flex-1">
                                    <x-input-label for="audit_team_lead" :value="__('Audit Team Leader')" />
                                    <select id="audit_team_lead" name="audit_team_lead"
                                        class="block mt-1 border w-3/4 rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="---">---</option>
                                        @foreach ($team_Leader as $leader)
                                            <option value="{{ $leader }}">{{ $leader }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('audit_team_lead')" class="mt-2" />
                                </div>

                                <!-- Responsible Person -->
                                <div class="mb-4 flex-1">
                                    <x-input-label for="responsible_person" :value="__('Responsible Person')" />
                                    <select id="responsible_person" name="responsible_person"
                                        class="block mt-1 border w-3/4 rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="---">---</option>
                                        @foreach ($responsible_person as $contact)
                                            <option value="{{ $contact }}">{{ $contact }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('responsible_person')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div>


                            <table class="w-full border border-gray-200"
                                style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Recommendation</th>
                                        <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                        <th class="border border-gray-200 px-4 py-2">Classification</th>
                                        <th class="border border-gray-200 px-4 py-2">Action Plan</th>
                                        <th class="border border-gray-200 px-4 py-2">Expected Date</th>
                                    </tr>
                                </thead>
                                <tbody id="dynamic_recommendations">
                                </tbody>
                            </table>

                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Save') }}
                                </x-primary-button>
                                <!-- <x-primary-button class='ml-2'>
                                        <a href="{{ route('action_plan1') }}" class="">Cancel</a>
                                    </x-primary-button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the relevant HTML elements
            const reportTitleSelect = document.getElementById('audit_report_title');
            const dynamicRecommendationsTable = document.getElementById('dynamic_recommendations');

            // Add an event listener to the report title select element
            reportTitleSelect.addEventListener('change', function() {
                // Get the selected report title
                const selectedTitle = reportTitleSelect.value;

                // Fetch recommendations based on the selected title using AJAX
                fetch('/get-recommendations/' + selectedTitle)
                    .then(response => response.json())
                    .then(recommendations => {
                        // Clear the existing content in the dynamic recommendations table
                        dynamicRecommendationsTable.innerHTML = '';

                        // Populate the table with the fetched recommendations
                        recommendations.forEach(recommendation => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                    <td class="border border-gray-200 px-4 py-2">
                                        <textarea name="audit_recommendations[]" class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" readonly>${recommendation.recommendation}</textarea>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <select name="current_implementation_status[]" class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                            <option value="Fully Implemented">Fully Implemented</option>
                                            <option value="Not Implemented">Not Implemented</option>
                                            <option value="Partially Implemented">Partially Implemented</option>
                                            <option value="No Update">No Update</option>
                                            <option value="No Longer Applicable">No Longer Applicable</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <select name="classfication[]" class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                            <option value="Critical">Critical</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <textarea name="action_plan[]" class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <input type="date" name="target_completion_date[]" class="block mt-1 border w-full rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline target-completion-date" required>
                                        <span class="text-red-500 text-xs mt-1 hidden">Please select a valid date.</span>
                                    </td>
                                `;
                            dynamicRecommendationsTable.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching recommendations:', error);
                    });
            });
        });
    </script>


    <script>
        // Close the alert when the close button is clicked
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.close-button');

            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.parentElement.style.display = 'none';
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
