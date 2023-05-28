<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'subject_id' => ['required', 'exists:subjects,id'],
            'questionnaire_group_id' => ['required', 'exists:questionnaire_groups,id'],
            'name' => [],
            'questions_count' => ['required', 'integer', 'min:0'],
        ];
    }
}
