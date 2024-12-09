@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Action Plan Details</h3>
        <div class="flex gap-2">
            <a href="{{ route('action-plans.edit', $actionPlan->id) }}"
                class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>
                                   
            </a>
            <form action="" method="POST" >
                @csrf
                @method('DELETE')
                <button class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500 delete_item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                      </svg>                  
                </button>
            </form>
        </div>
    </div>

    <div class="flex flex-col mt-4">
        <div class="page-subheading" >{{$actionPlan->audit_report_title}}</div>
        <div class="bg-white shadow-md rounded-md overflow-hidden">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center">
                    <div class="flex flex-col">
                        <span class="text-gray-700 font-semibold">Country Office</span>
                        <span class="text-gray-700">{{$actionPlan->country_office}}</span>
                    </div>
                    
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Date of Audit</span>
                        <span class="text-gray-700">{{$actionPlan->date_of_audit->format('d M Y')}}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Head of Audited Entity</span>
                        <span class="text-gray-700">{{$actionPlan->head_of_audited_entity}}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Audited Entity Focal Point</span>
                        <span class="text-gray-700">{{$actionPlan->audited_entity_focal_point}}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Status</span>
                        <span class="text-gray-700">{{$actionPlan->current_implementation_status}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-md overflow-hidden mt-2">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center">
                    <div class="flex flex-col">
                        <span class="text-gray-700 font-semibold">Audit Team Lead</span>
                        <span class="text-gray-700">{{$actionPlan->audit_team_lead}}</span>
                    </div>
                    
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Audit Report Title</span>
                        <span class="text-gray-700">{{$actionPlan->audit_report_title}}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Responsible Person</span>
                        <span class="text-gray-700">{{$actionPlan->responsible_person}}</span>
                    </div>
                    <div class="flex flex-col mt-2 md:mt-0">
                        <span class="text-gray-700 font-semibold">Target completion date</span>
                        <span class="text-gray-700">{{$actionPlan->target_completion_date->format('d M Y')}}</span>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-md overflow-hidden mt-2">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center">
                    <div class="flex flex-col">
                        <span class="text-gray-700 font-semibold">Audit Recommendation</span>
                        <span class="text-gray-700">{{$actionPlan->audit_recommendations}}</span>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-md overflow-hidden mt-2">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between md:items-center">
                    <div class="flex flex-col">
                        <span class="text-gray-700 font-semibold">Action Plan</span>
                        <span class="text-gray-700">{{$actionPlan->audit_recommendations}}</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection

