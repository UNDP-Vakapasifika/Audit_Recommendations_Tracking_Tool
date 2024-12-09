@extends('layouts.master')

@section('body')
<h3 class="page-heading">Change Implementation Status</h3>

@if(session('success'))
    <div class="bg-green-500 text-white p-4">
        {{ session('success') }}
    </div>
@endif

<div class="pt-4">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold mb-4"></h2>
                    <a href="javascript:void(0);" onclick="history.back()"
                       class="font-semibold text-xl text-gray-800 leading-tight">Back</a>
                </div>
                <form action="{{ route('updatestatus', $finalReport->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex space-x-4">
                        <!-- The title -->
                        <div class="mb-4 flex-1">
                            <label for="audit_report_title" class="block text-sm font-medium text-gray-600">Report
                                Title</label>
                            <textarea name="audit_report_title" id="audit_report_title"
                                      class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                      readonly
                                      required>{{ old('audit_report_title', $finalReport->audit_report_title) }}</textarea>
                        </div>
                        
                        <!-- Audit Recommendations -->
                        <div class="mb-4 flex-1">
                            <label for="audit_recommendations" class="block text-sm font-medium text-gray-600">Audit
                                Recommendations</label>
                            <textarea name="audit_recommendations" id="audit_recommendations"
                                      class="block mt-1 w-full border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                      readonly
                                      required>{{ old('audit_recommendations', $finalReport->audit_recommendations) }}</textarea>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <!-- Current Implementation Status -->
                        <div class="mb-4 flex-1">
                            <label for="current_implementation_status"
                                   class="block text-sm font-medium text-gray-600">Current Implementation
                                Status</label>
                            <select id="current_implementation_status" name="current_implementation_status"
                                    class="w-full block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                                <option
                                    value="Fully Implemented" {{ $finalReport->current_implementation_status == 'Fully Implemented' ? 'selected' : '' }}>
                                    Fully Implemented
                                </option>
                                <option
                                    value="Partially Implemented" {{ $finalReport->current_implementation_status == 'Partially Implemented' ? 'selected' : '' }}>
                                    Partially Implemented
                                </option>
                                <option
                                    value="Not Implemented" {{ $finalReport->current_implementation_status == 'Not Implemented' ? 'selected' : '' }}>
                                    Not Implemented
                                </option>
                                <option
                                    value="No Update" {{ $finalReport->current_implementation_status == 'No Update' ? 'selected' : '' }}>
                                    No Update
                                </option>
                                <option
                                    value="No Longer Applicable" {{ $finalReport->current_implementation_status == 'No Longer Applicable' ? 'selected' : '' }}>
                                    No Longer Applicable
                                </option>
                                <!-- No Longer Applicable -->
                            </select>
                        </div>
                        <!-- Target Completion Date -->
                        <div class="mb-4 flex-1">
                            <label for="target_completion_date" class="block text-sm font-medium text-gray-600">Target
                                Completion Date</label>
                            <input type="date" name="target_completion_date" id="target_completion_date"
                                   class="w-full block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                   value="{{ old('target_completion_date', $finalReport->target_completion_date) }}"
                                   required>
                        </div>
                        <!-- Evidence -->
                        <div class="mb-4 flex-1">
                            <label for="evidence" class="block text-sm font-medium text-gray-600">Evidence (PDF, DOC, DOCX)</label>
                            <input type="file" name="evidence" id="evidence"
                                   class="w-full block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                   required>
                        </div>
                        <!-- Impact -->
                        <div class="mb-4 flex-1">
                            <label for="impact" class="block text-sm font-medium text-gray-600">Impact (PDF, DOC, DOCX)</label>
                            <input type="file" name="impact" id="impact"
                                   class="w-full block mt-1 border rounded-md py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                   required>
                        </div>
                    </div>
                    <div class="flex justify-center mt-3">
                        <x-primary-button>
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
