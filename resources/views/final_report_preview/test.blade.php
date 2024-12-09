@extends('layouts.master')

@section('body')
    <div class="flex flex-col md:flex-row justify-start md:justify-between md:items-center">
        <h3 class="page-heading">Final Report Preview</h3>
    </div>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Form for the preview table -->
                    <form action="{{ route('final_report.confirm') }}" method="POST">
                        @csrf
                        <div class="p-4">
                            <table class="w-full border border-gray-200 mt-3" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Country Office</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Type</th>
                                        <th class="border border-gray-200 px-4 py-2">Date of Audit</th>
                                        <th class="border border-gray-200 px-4 py-2">Publication Date</th>
                                        <th class="border border-gray-200 px-4 py-2">Page/Par Reference</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Recommendations</th>
                                        <th class="border border-gray-200 px-4 py-2">Classification</th>
                                        <th class="border border-gray-200 px-4 py-2">Key Issues</th>
                                        <th class="border border-gray-200 px-4 py-2">Acceptance Status</th>
                                        <th class="border border-gray-200 px-4 py-2">Current Implementation Status</th>
                                        <th class="border border-gray-200 px-4 py-2">Reason Not Implemented</th>
                                        <th class="border border-gray-200 px-4 py-2">Follow-Up Date</th>
                                        <th class="border border-gray-200 px-4 py-2">Target Completion Date</th>
                                        <!-- <th class="border border-gray-200 px-4 py-2">Repeated Finding</th> -->
                                        <th class="border border-gray-200 px-4 py-2">Action Plan</th>
                                        <th class="border border-gray-200 px-4 py-2">Summary of Response</th>
                                        <th class="border border-gray-200 px-4 py-2">Mainstream Category</th>
                                        <th class="border border-gray-200 px-4 py-2">SAI Responsible Person</th>
                                        <!-- <th class="border border-gray-200 px-4 py-2">Head of Audited Entity</th> -->
                                        <th class="border border-gray-200 px-4 py-2">Client Name</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Team Lead</th>
                                        <th class="border border-gray-200 px-4 py-2">Client Focal Point</th>
                                        <th class="border border-gray-200 px-4 py-2">Head of Client</th>
                                    </tr>
                                </thead>
                                <!-- Check if data exists in session -->
                                @php
                                    $data = session('parsedCSVData');
                                @endphp

                                <!-- Ensure data is available before rendering the table body -->
                                @if($data)
                                    <tbody>
                                        <!-- Iterate through each entry in the data array -->
                                        @foreach ($data as $index => $row)
                                            <tr>
                                                <!-- Displaying data from the CSV file -->
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[0] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[1] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[2] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[3] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[4] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[5] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[6] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[7] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[10] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[11] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[12] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[13] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[14] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[15] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[17] }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $row[24] }}</td>
                                                
                                                <td class="border border-gray-200 px-4 py-2">
                                                    <!-- Dropdown for Client -->
                                                    <select name="mainstream_category[{{ $index }}]" class="form-select w-full" required>
                                                        <option value="" selected>-- Choose Category --</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="border border-gray-200 px-4 py-2">
                                                    <!-- Dropdown for Responsible Person -->
                                                    <select name="responsible_person[{{ $index }}]" class="form-select w-full" required>
                                                        <option value="" selected>-- Choose Responsible Person --</option>
                                                        @foreach ($sai_responsible_person as $user)
                                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="border border-gray-200 px-4 py-2">
                                                    <!-- Dropdown for Client -->
                                                    <select name="client[{{ $index }}]" class="form-select w-full" required>
                                                        <option value="" selected>-- Choose Client --</option>
                                                        @foreach ($leadBodies as $leadBody)
                                                            <option value="{{ $leadBody->id }}">{{ $leadBody->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="border border-gray-200 px-4 py-2">
                                                    <!-- Dropdown for Head of Audited Entity -->
                                                    <select name="head_of_audited_entity[{{ $index }}]" class="form-select w-full" required>
                                                        <option value="" selected>-- Choose team lead --</option>
                                                        @foreach ($team_lead as $user)
                                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="border border-gray-200 px-4 py-2">
                                                    <!-- Dropdown for Audited Entity Focal Point -->
                                                    <select name="audited_entity_focal_point[{{ $index }}]" class="form-select w-full" required>
                                                        <option value="" selected>-- Choose focal point --</option>
                                                        @foreach ($client_focal_point as $user)
                                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="border border-gray-200 px-4 py-2">
                                                    <!-- Dropdown for Audit Team Lead -->
                                                    <select name="audit_team_lead[{{ $index }}]" class="form-select w-full" required>
                                                        <option value="" selected>-- Choose client head --</option>
                                                        @foreach ($client_head as $user)
                                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <p>No data found in session. Please upload a CSV file.</p>
                                @endif

                            </table>
                        </div>

                        <!-- Submit button -->
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                Confirm and Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
