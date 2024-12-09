<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRecommendationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'report_numbers' => $this->reportNumbersRule(),
            'report_title' => 'required',
            'audit_type' => 'required',
            'publication_date' => 'required|date|before_or_equal:today',
            'page_par_reference' => 'required',
            'recommendation' => 'required',
            'client' => 'required|exists:lead_bodies,id',
            'sector' => 'required',
            'key_issues' => 'required',
            'acceptance_status' => 'required',
            'implementation_status' => 'required',
            'recurence' => 'required',
            'follow_up_date' => 'required|date|before:actual_expected_imp_date|after_or_equal:today',
            'actual_expected_imp_date' => 'required|date|after_or_equal:today',
            'sai_confirmation' => 'required',
            'responsible_entity' => 'required',
            'summary_of_response' => 'required',
        ];
    }

    private function reportNumbersRule(): string
    {
        if ($this->route('recommendation') === null) {
            return 'required|unique:recommendations,report_numbers';
        }
        return 'required|unique:recommendations,report_numbers,' . $this->route('recommendation')->id;
    }
}
