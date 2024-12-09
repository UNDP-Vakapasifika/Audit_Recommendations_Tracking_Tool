@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Action Plan Decline Details</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container mx-auto p-4">
                <!-- Ensure there's at least one report detail before accessing its title -->
                @if(count($reportDetails) > 0)
                    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
                        <h2 class="text-2xl font-bold mb-4">{{ $reportDetails[0]['reportTitle'] }}</h2>
                        <a href="javascript:void(0);" onclick="history.back()" class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>
                @else
                    <h2 class="text-2xl font-bold mb-4">No Report Title Available</h2>
                @endif                        
                <div style="overflow-x: auto;">
                    <table class="w-full border border-gray-200"
                        style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Department</th>
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
                                <th class="border border-gray-200 px-4 py-2">Reason</th>
                                <th class="border border-gray-200 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportDetails as $actionPlan)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['countryOffice'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['auditRecommendations'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['currentImplementationStatus'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['classification'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['dateOfAudit'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['headOfAuditedEntity'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['auditedEntityFocalPoint'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['auditTeamLead'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['actionPlan'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['targetCompletionDate'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['responsiblePerson'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['reason'] }}</td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <a href="{{ route('action-plan.edit', $actionPlan['id']) }}" class="text-blue-500 hover:underline">Edit</a>
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
