<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Edit The Action Plan') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4"></h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                    <form action="{{ route('update-action-plan', $actionPlan->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="flex space-x-4">  
                            <!-- Report Title -->
                            <div class="mb-4 flex-1">
                                <label for="audit_report_title" class="block text-sm font-medium text-gray-600">Report Title</label>
                                <textarea name="audit_report_title" id="audit_report_title" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" readonly required>{{ old('audit_report_title', $actionPlan->audit_report_title) }}</textarea>
                            </div>
                        </div>

                        <div class="flex space-x-4"> 
                            <!-- Audit Recommendations -->
                            <div class="mb-4 flex-1">
                                <label for="audit_recommendations" class="block text-sm font-medium text-gray-600">Audit Recommendations</label>
                                <textarea name="audit_recommendations" id="audit_recommendations" class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" readonly required>{{ old('audit_recommendations', $actionPlan->audit_recommendations) }}</textarea>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <!-- Country Office -->
                            <div class="mb-4 flex-1">
                                <label for="country_office_name" class="block text-sm font-medium text-gray-600">Department</label>
                                <input type="text" name="country_office_name" id="country_office_name" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('country_office_name', $countryOfficeName) }}" readonly required>
                                <input type="hidden" name="country_office" value="{{ old('country_office', $actionPlan->country_office) }}">
                            </div>

                            <!-- Date of Audit -->
                            <div class="mb-4 flex-1">
                                <label for="date_of_audit" class="block text-sm font-medium text-gray-600">Date of Audit</label>
                                <input type="date" name="date_of_audit" id="date_of_audit" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('date_of_audit', $actionPlan->date_of_audit) }}" required>
                            </div>

                            <!-- Name of Head of Audited Entity/Representative -->
                            <div class="mb-4 flex-1">
                                <label for="head_of_audited_entity_name" class="block text-sm font-medium text-gray-600">Head of Audited Entity Name</label>
                                <input type="text" name="head_of_audited_entity_name" id="head_of_audited_entity_name" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('head_of_audited_entity_name', $headOfAuditedEntity ? $headOfAuditedEntity->name : '') }}" readonly required>
                                <input type="hidden" name="head_of_audited_entity" value="{{ old('head_of_audited_entity', $actionPlan->head_of_audited_entity) }}">
                            </div>

                            <!-- Current Implementation Status -->
                            <div class="mb-4 flex-1">
                                <label for="current_implementation_status" class="block text-sm font-medium text-gray-600">Current Implementation Status</label>
                                <select id="current_implementation_status" name="current_implementation_status" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="Fully Implemented" {{ $actionPlan->current_implementation_status == 'Fully Implemented' ? 'selected' : '' }}>Fully Implemented</option>
                                    <option value="Partially Implemented" {{ $actionPlan->current_implementation_status == 'Partially Implemented' ? 'selected' : '' }}>Partially Implemented</option>
                                    <option value="Not Implemented" {{ $actionPlan->current_implementation_status == 'Not Implemented' ? 'selected' : '' }}>Not Implemented</option>
                                    <option value="No Update" {{ $actionPlan->current_implementation_status == 'No Update' ? 'selected' : '' }}>No Update</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <!-- Name of Audited Entity Focal Point -->
                            <div class="mb-4 flex-1">
                                <label for="audited_entity_focal_point_name" class="block text-sm font-medium text-gray-600">Audited Entity Focal Point Name</label>
                                <input type="text" name="audited_entity_focal_point_name" id="audited_entity_focal_point_name" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('audited_entity_focal_point_name', $auditedEntityFocalPoint ? $auditedEntityFocalPoint->name : '') }}" readonly required>
                                <input type="hidden" name="audited_entity_focal_point" value="{{ old('audited_entity_focal_point', $actionPlan->audited_entity_focal_point) }}">
                            </div>

                            <!-- Name of Audit Team Lead from AUDIT OFFICE -->
                            <div class="mb-4 flex-1">
                                <label for="audit_team_lead_name" class="block text-sm font-medium text-gray-600">Audit Team Lead Name</label>
                                <input type="text" name="audit_team_lead_name" id="audit_team_lead_name" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('audit_team_lead_name', $auditTeamLead ? $auditTeamLead->name : '') }}" readonly required>
                                <input type="hidden" name="audit_team_lead" value="{{ old('audit_team_lead', $actionPlan->audit_team_lead) }}">
                            </div>

                            <!-- Responsible Person -->
                            <div class="mb-4 flex-1">
                                <label for="responsible_person_name" class="block text-sm font-medium text-gray-600">Responsible Person</label>
                                <input type="text" name="responsible_person_name" id="responsible_person_name" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('responsible_person_name', $responsiblePerson ? $responsiblePerson->name : '') }}" readonly required>
                                <input type="hidden" name="responsible_person" value="{{ old('responsible_person', $actionPlan->responsible_person) }}">
                            </div>

                            <!-- Target Completion Date -->
                            <div class="mb-4 flex-1">
                                <label for="target_completion_date" class="block text-sm font-medium text-gray-600">Target Completion Date</label>
                                <input type="date" name="target_completion_date" id="target_completion_date" class="w-3/4 block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('target_completion_date', $actionPlan->target_completion_date) }}" required>
                            </div>
                        </div>

                        <div class="flex space-x-4">  
                            <!-- Action Plan -->
                            <div class="mb-4 flex-1">
                                <label for="action_plan" class="block text-sm font-medium text-gray-600">Action Plan</label>
                                <textarea name="action_plan" id="action_plan" class="block w-full mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('action_plan', $actionPlan->action_plan) }}</textarea>
                            </div>
                        </div>

                        <div class="text-center col-span-2 mt-3">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="home-footer mt-4 mx-auto">
        <p>&copy; <span id="currentYear">2023</span> United Nations Development Programme</p>
    </footer>
    
    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>
</x-app-layout>
