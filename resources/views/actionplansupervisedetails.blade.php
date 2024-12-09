@extends('layouts.master')

@section('body')
    <h3 class="page-heading">Action Plan Report Details</h3>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold mb-4">{{ $reportDetails[0]['reportTitle'] }}</h2>
                        <a href="javascript:void(0);" onclick="history.back()"
                           class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="w-full border border-gray-200" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <!-- <th class="border border-gray-200 px-4 py-2">Country Office</th> -->
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
                                    <th class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 2;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportDetails as $actionPlan)
                                    <tr>
                                        <!-- <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['countryOffice'] }}</td> -->
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['recommendation'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['currentImplementationStatus'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['classification'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['dateOfAudit'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['headOfAuditedEntity'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['auditedEntityFocalPoint'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['auditTeamLead'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['actionPlan'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['targetCompletionDate'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2">{{ $actionPlan['responsiblePerson'] }}</td>
                                        <td class="border border-gray-200 px-4 py-2 bg-white" style="position: sticky; right: 0; z-index: 1;">
                                            <form action="{{ route('updateactionplan', ['id' => $actionPlan['id']]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" name="status" value="approved">

                                                <button type="submit" class="text-blue-500 hover:underline">
                                                    <i class="fa fa-check"></i> Approve
                                                </button>
                                            </form>

                                            <button type="button" class="text-red-500 hover:underline" onclick="showDeclineModal('{{ $actionPlan['id'] }}')">
                                                <i class="fa fa-times"></i> Decline
                                            </button>

                                            <div id="declineModal-{{ $actionPlan['id'] }}" class="modal" style="display: none;">
                                                <form id="declineForm-{{ $actionPlan['id'] }}" action="{{ route('updateactionplan', ['id' => $actionPlan['id']]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden" name="status" value="declined">

                                                    <label for="declineReason">Reason for Decline:</label><br>
                                                    <textarea name="reason" id="declineReason" required></textarea><br>

                                                    <button type="submit" class="text-red-500 hover:underline">
                                                        <i class="fa fa-times"></i> Accept
                                                    </button>
                                                </form>
                                            </div>
                                            <script>
                                                function showDeclineModal(actionPlanId) {
                                                    document.getElementById('declineModal-' + actionPlanId).style.display = 'block';
                                                }
                                            </script>
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
