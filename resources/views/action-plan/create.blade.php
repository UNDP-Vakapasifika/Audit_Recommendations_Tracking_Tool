@extends('layouts.master')

@section('body')
    <h3 class="page-heading">
        {{ isset($actionPlan) ? 'Edit Action Plan' : 'Add Action Plan' }}
    </h3>
   
    <div class="max-w-7xl mx-auto pt-6 ">
    
        <x-validation-errors class="mb-4" :errors="$errors" />

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold mb-4"></h2>
                <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
            </div>
            
            <form method="post"
                action="{{ isset($actionPlan) ? route('action-plans.update', $actionPlan->id) : route('createaction2') }}">
                @csrf

                @if (isset($actionPlan))
                    @method('PUT')
                @endif
                
                <div class="p-4">
                    <div class="flex flex-wrap gap-y-3 gap-x-0">
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="country_office_name" :value="__('Country Office')" />
                            <x-text-input id="country_office_name" class="block mt-1 w-full" type="text"
                                name="country_office_name" :value="old('country_office_name', $countryOfficeName)" readonly required />
                            <input type="hidden" name="country_office" value="{{ old('country_office', $actionPlan->country_office) }}">
                            <x-input-error class="mt-2" :messages="$errors->get('country_office')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="date_of_audit" :value="__('Date of Audit')" />
                            <x-text-input id="date_of_audit" class="block mt-1 w-full" type="date" name="date_of_audit"
                                :value="old('date_of_audit', $actionPlan->date_of_audit)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_of_audit')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="head_of_audited_entity_name" :value="__('Head of Audited Entity')" />
                            <x-text-input id="head_of_audited_entity_name" class="block mt-1 w-full" type="text"
                                name="head_of_audited_entity_name" :value="old('head_of_audited_entity_name', $headOfAuditedEntityName)" readonly required />
                            <input type="hidden" name="head_of_audited_entity" value="{{ old('head_of_audited_entity', $actionPlan->head_of_audited_entity) }}">
                            <x-input-error class="mt-2" :messages="$errors->get('head_of_audited_entity')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="audited_entity_focal_point_name" :value="__('Audited Entity Focal Point')" />
                            <x-text-input id="audited_entity_focal_point_name" class="block mt-1 w-full" type="text"
                                name="audited_entity_focal_point_name" :value="old('audited_entity_focal_point_name', $auditedEntityFocalPointName)" readonly required />
                            <input type="hidden" name="audited_entity_focal_point" value="{{ old('audited_entity_focal_point', $actionPlan->audited_entity_focal_point) }}">
                            <x-input-error class="mt-2" :messages="$errors->get('audited_entity_focal_point')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="audit_team_lead_name" :value="__('Audit Team Lead')" />
                            <x-text-input id="audit_team_lead_name" class="block mt-1 w-full" type="text"
                                name="audit_team_lead_name" :value="old('audit_team_lead_name', $auditTeamLeadName)" readonly required />
                            <input type="hidden" name="audit_team_lead" value="{{ old('audit_team_lead', $actionPlan->audit_team_lead) }}">
                            <x-input-error class="mt-2" :messages="$errors->get('audit_team_lead')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="responsible_person_name" :value="__('Responsible Person')" />
                            <x-text-input id="responsible_person_name" class="block mt-1 w-full" type="text"
                                name="responsible_person_name" :value="old('responsible_person_name', $responsiblePersonName)" readonly required />
                            <input type="hidden" name="responsible_person" value="{{ old('responsible_person', $actionPlan->responsible_person) }}">
                            <x-input-error class="mt-2" :messages="$errors->get('responsible_person')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="current_implementation_status">{{ __('Current Implementation Status') }}</x-input-label>
                            <x-select-input id="current_implementation_status" class="block mt-1 w-full" type="text"
                                name="current_implementation_status" :value="old('current_implementation_status')" required>
                                <option value="">-- Select an option --</option>
                                <option value="Fully Implemented" @if (isset($actionPlan) && $actionPlan->current_implementation_status === 'Fully Implemented') selected @endif>Fully
                                    Implemented</option>
                                <option value="Partially Implemented" @if (isset($actionPlan) && $actionPlan->current_implementation_status === 'Partially Implemented') selected @endif>
                                    Partially Implemented</option>
                                <option value="Not Implemented" @if (isset($actionPlan) && $actionPlan->current_implementation_status === 'Not Implemented') selected @endif>Not
                                    Implemented</option>
                                <option value='No Update' @if (isset($actionPlan) && $actionPlan->current_implementation_status === 'No Update') selected @endif>No Update</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('current_implementation_status')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="target_completion_date">{{ __('Target Completion Date') }}</x-input-label>
                            <x-text-input id="target_completion_date" class="block mt-1 w-full" type="date"
                                name="target_completion_date" :value="old('target_completion_date', $actionPlan->target_completion_date)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('target_completion_date')" />
                        </div>

                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <x-input-label for="audit_report_title" :value="__('Audit Report Title')" />
                            <x-text-input id="audit_report_title" class="block mt-1 w-full" type="text"
                                name="audit_report_title" :value="old('audit_report_title', $reportTitle)" readonly required />
                            <x-input-error class="mt-2" :messages="$errors->get('audit_report_title')" />
                        </div>

                        <div class="w-full md:w-1/2 ">
                            <x-input-label for="audit_recommendations" :value="__('Audit Recommendations')" />
                            <x-textarea-input id="audit_recommendations" class="block mt-1 w-full" type="text"
                                name="audit_recommendations" :value="old('audit_recommendations', $auditRecommendations)" readonly required />
                            <x-input-error class="mt-2" :messages="$errors->get('audit_recommendations')" />
                        </div>

                        <div class="w-full md:w-1/2">
                            <x-input-label for="action_plan" :value="__('Action Plan')" />
                            <x-textarea-input id="action_plan" class="block mt-1 w-full" type="text" name="action_plan"
                                :value="old('action_plan', $actionPlan->action_plan)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('action_plan')" />
                        </div>
                    </div>
                    @if(auth()->user()->can('edit action plan'))
                        <div class="flex justify-end mt-4">
                            <x-primary-button>
                                {{ isset($actionPlan) ? 'Update Action Plan' : 'Add Action Plan' }}
                            </x-primary-button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
