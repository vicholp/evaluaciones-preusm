<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireFromPrototypeRequest extends FormRequest
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
            'questionnaire_group_id' => ['required', 'exists:questionnaire_groups,id'],
            'questionnaire_prototype_id' => ['required', 'exists:questionnaire_prototypes,id'],
            'name' => [],
        ];
    }
}
