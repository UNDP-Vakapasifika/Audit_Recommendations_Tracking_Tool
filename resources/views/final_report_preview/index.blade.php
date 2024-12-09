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
                            <input type="text" id="searchInput" placeholder="Search Reports..." class="mb-4 px-4 py-2 border rounded">

                            <table class="w-full border border-gray-200 mt-3" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2">Country Office</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Report Title</th>
                                        <th class="border border-gray-200 px-4 py-2">Audit Type</th>
                                        <th class="border border-gray-200 px-4 py-2">Date of Audit</th>
                                        <th class="border border-gray-200 px-4 py-2">Publication Date</th>
                                        <th class="border border-gray-200 px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBody">
                                    @php
                                        $data = session('parsedCSVData');
                                        $groupedReports = [];

                                        // Group data by unique report title
                                        if ($data) {
                                            foreach ($data as $index => $row) {
                                                if (isset($row[1])) { // Ensure the key exists before accessing
                                                    $reportKey = $row[1];
                                                    $groupedReports[$reportKey][] = $row;
                                                }
                                            }
                                        }
                                    @endphp

                                    @if($groupedReports)
                                        @foreach ($groupedReports as $reportTitle => $reportRows)
                                            <tr class="bg-gray-100 cursor-pointer">
                                                <td class="border border-gray-200 px-4 py-2">{{ $reportRows[0][0] ?? 'N/A' }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $reportTitle }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $reportRows[0][2] ?? 'N/A' }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $reportRows[0][3] ?? 'N/A' }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $reportRows[0][4] ?? 'N/A' }}</td>
                                                <td class="border border-gray-200 px-4 py-2">
                                                    <button type="button" class="text-blue-500" onclick="toggleRecommendations('{{ md5($reportTitle) }}')">Toggle Recommendations</button>
                                                </td>
                                            </tr>
                                            <tr id="recommendations-{{ md5($reportTitle) }}" class="hidden">
                                                <td colspan="6">
                                                    <div class="px-4 py-2">
                                                        <h4 class="font-semibold">Recommendations:</h4>
                                                        <ul>
                                                            @foreach ($reportRows as $rowIndex => $row)
                                                                <li class="my-2 border-t border-gray-200 pt-2">
                                                                    <div><strong>Page/Par Reference:</strong> {{ $row[5] ?? 'N/A' }}</div>
                                                                    <div><strong>Recommendation:</strong> {{ $row[6] ?? 'N/A' }}</div>
                                                                    <div><strong>Classification:</strong> {{ $row[7] ?? 'N/A' }}</div>
                                                                    <div><strong>Key Issues:</strong> {{ $row[10] ?? 'N/A' }}</div>
                                                                    <div><strong>Acceptance Status:</strong> {{ $row[11] ?? 'N/A' }}</div>
                                                                    <div><strong>Current Implementation Status:</strong> {{ $row[12] ?? 'N/A' }}</div>
                                                                    <div><strong>Reason Not Implemented:</strong> {{ $row[13] ?? 'N/A' }}</div>
                                                                    <div><strong>Follow-Up Date:</strong> {{ $row[14] ?? 'N/A' }}</div>
                                                                    <div><strong>Target Completion Date:</strong> {{ $row[15] ?? 'N/A' }}</div>
                                                                    <div><strong>Action Plan:</strong> {{ $row[17] ?? 'N/A' }}</div>
                                                                    <div><strong>Response Summary:</strong> {{ $row[24] ?? 'N/A' }}</div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <!-- Dropdowns for additional associations -->
                                                        <div class="flex flex-wrap gap-4">
                                                            <div class="w-full sm:w-1/2 lg:w-1/3 mt-2">
                                                                <label for="mainstream_category_{{ md5($reportTitle) }}" class="block mb-1">Category:</label>
                                                                <select name="mainstream_category[{{ md5($reportTitle) }}]" class="form-select w-full" required>
                                                                    <option value="" selected>-- Choose Category --</option>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="w-full sm:w-1/2 lg:w-1/3 mt-2">
                                                                <label for="responsible_person_{{ md5($reportTitle) }}" class="block mb-1">Responsible Person:</label>
                                                                <select name="responsible_person[{{ md5($reportTitle) }}]" class="form-select w-full" required>
                                                                    <option value="" selected>-- Choose Responsible Person --</option>
                                                                    @foreach ($sai_responsible_person as $user)
                                                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="w-full sm:w-1/2 lg:w-1/3 mt-2">
                                                                <label for="client_{{ md5($reportTitle) }}" class="block mb-1">Client:</label>
                                                                <select name="client[{{ md5($reportTitle) }}]" class="form-select w-full" required>
                                                                    <option value="" selected>-- Choose Client --</option>
                                                                    @foreach ($leadBodies as $leadBody)
                                                                        <option value="{{ $leadBody->id }}">{{ $leadBody->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="w-full sm:w-1/2 lg:w-1/3 mt-2">
                                                                <label for="head_of_audited_entity_{{ md5($reportTitle) }}" class="block mb-1">Head of Audited Entity:</label>
                                                                <select name="head_of_audited_entity[{{ md5($reportTitle) }}]" class="form-select w-full" required>
                                                                    <option value="" selected>-- Choose Head of Audited Entity --</option>
                                                                    @foreach ($team_lead as $user)
                                                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="w-full sm:w-1/2 lg:w-1/3 mt-2">
                                                                <label for="audited_entity_focal_point_{{ md5($reportTitle) }}" class="block mb-1">Audited Entity Focal Point:</label>
                                                                <select name="audited_entity_focal_point[{{ md5($reportTitle) }}]" class="form-select w-full" required>
                                                                    <option value="" selected>-- Choose Focal Point --</option>
                                                                    @foreach ($client_focal_point as $user)
                                                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="w-full sm:w-1/2 lg:w-1/3 mt-2">
                                                                <label for="audit_team_lead_{{ md5($reportTitle) }}" class="block mb-1">Audit Team Lead:</label>
                                                                <select name="audit_team_lead[{{ md5($reportTitle) }}]" class="form-select w-full" required>
                                                                    <option value="" selected>-- Choose Audit Team Lead --</option>
                                                                    @foreach ($client_head as $user)
                                                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="6">No data found in session. Please upload a CSV file.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

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

    <script>
        function toggleRecommendations(index) {
            const element = document.getElementById('recommendations-' + index);
            element.classList.toggle('hidden');
        }

        // Simple search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#reportTableBody tr');

            rows.forEach(row => {
                const columns = row.querySelectorAll('td');
                const text = columns.length ? columns[1].textContent.toLowerCase() : '';

                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endsection
