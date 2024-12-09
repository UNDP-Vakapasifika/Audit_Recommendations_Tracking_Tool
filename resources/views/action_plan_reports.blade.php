@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Action Plan details</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4">
                            @if (!empty($reportDetails))
                                {{ $reportDetails[0]['report_title'] }}
                            @endif
                        </h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>

                    <div  style="overflow-x: auto;">
                        <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-4 py-2">Country Office</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Recommendations</th>
                                    <th class="border border-gray-200 px-4 py-2">Implementation Status</th>
                                    <th class="border border-gray-200 px-4 py-2">Classification</th>
                                    <th class="border border-gray-200 px-4 py-2">Date of Audit</th>
                                    <th class="border border-gray-200 px-4 py-2">Head of Audited Entity</th>
                                    <th class="border border-gray-200 px-4 py-2">Entity Focal Point</th>
                                    <th class="border border-gray-200 px-4 py-2">Audit Team Lead</th>
                                    <th class="border border-gray-200 px-4 py-2">Action Plan</th>
                                    <th class="border border-gray-200 px-4 py-2">Target Completion Date</th>
                                    <th class="border border-gray-200 px-4 py-2">Responsible Person</th>
                                    <th class="border border-gray-200 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportDetails as $actionPlan)
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['country_office'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['recommendation'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['current_implementation_status'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['classification'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['date_of_audit'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['head_of_audited_entity'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['audited_entity_focal_point'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['audit_team_lead'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['action_plan'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['target_completion_date'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['responsible_person'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            <a href="{{ route('action-plan.edit', $actionPlan['id']) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <!-- <form action="#" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
