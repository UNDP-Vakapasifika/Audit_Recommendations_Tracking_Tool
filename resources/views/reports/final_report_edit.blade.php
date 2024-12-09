@extends('layouts.master')

@section('body')

    @if (!isset($recommendation))
        <h3 class="page-subheading">Edit Final Report</h3>
    @endif

    <x-validation-errors class="mb-4" :errors="$errors" />

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form action="{{ route('final.recommendations.update', $finalReport->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Start of Grid System -->
             <div class="p-4">
                <div class="flex flex-wrap gap-y-3 gap-x-0">
                    <!-- Audit Report Title -->
                    <div class="w-full">
                        <label for="audit_report_title" class="block text-sm font-medium text-gray-700">Audit Report Title:</label>
                        <input type="text" name="audit_report_title" id="audit_report_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $finalReport->audit_report_title }}" required>
                    </div>

                    <!-- Audit Recommendations -->
                    <div class="w-full">
                        <label for="audit_recommendations" class="block text-sm font-medium text-gray-700">Audit Recommendations:</label>
                        <textarea name="audit_recommendations" id="audit_recommendations" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ $finalReport->audit_recommendations }}</textarea>
                    </div>

                    <!-- Action Plan -->
                    <div class="w-full">
                        <label for="action_plan" class="block text-sm font-medium text-gray-700">Action Plan:</label>
                        <textarea name="action_plan" id="action_plan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ $finalReport->action_plan }}</textarea>
                    </div>

                    <!-- Summary of Response -->
                    <div class="w-full">
                        <label for="summary_of_response" class="block text-sm font-medium text-gray-700">Summary of Response:</label>
                        <textarea name="summary_of_response" id="summary_of_response" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $finalReport->summary_of_response }}</textarea>
                    </div>

                    <!-- Date of Audit -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="date_of_audit" class="block text-sm font-medium text-gray-700">Date of Audit:</label>
                        <input type="date" name="date_of_audit" id="date_of_audit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $finalReport->date_of_audit->format('Y-m-d') }}" required>
                    </div>

                    <!-- Publication Date -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="publication_date" class="block text-sm font-medium text-gray-700">Publication Date:</label>
                        <input type="date" name="publication_date" id="publication_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $finalReport->publication_date->format('Y-m-d') }}" required>
                    </div>

                    <!-- Page Par Reference -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="page_par_reference" class="block text-sm font-medium text-gray-700">Page Par Reference:</label>
                        <input type="text" name="page_par_reference" id="page_par_reference" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $finalReport->page_par_reference }}" required>
                    </div>

                    <!-- Classification Dropdown -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="classification" class="block text-sm font-medium text-gray-700">Classification:</label>
                        <select name="classification" id="classification" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            @foreach($classificationOptions as $option)
                                <option value="{{ $option }}" {{ $finalReport->classification == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Implementation Status Dropdown -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="current_implementation_status" class="block text-sm font-medium text-gray-700">Implementation Status:</label>
                        <select name="current_implementation_status" id="current_implementation_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            @foreach($implementationStatusOptions as $status)
                                <option value="{{ $status }}" {{ $finalReport->current_implementation_status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Target Completion Date -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="target_completion_date" class="block text-sm font-medium text-gray-700">Target Completion Date:</label>
                        <input type="date" name="target_completion_date" id="target_completion_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $finalReport->target_completion_date->format('Y-m-d') }}" required>
                    </div>

                    <!-- Follow Up Date -->
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <label for="follow_up_date" class="block text-sm font-medium text-gray-700">Follow Up Date:</label>
                        <input type="date" name="follow_up_date" id="follow_up_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $finalReport->follow_up_date->format('Y-m-d') }}" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
             </div>
            <!-- End of Grid System -->


        </form>
    </div>

@endsection
