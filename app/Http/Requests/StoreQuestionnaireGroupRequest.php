<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|string',
            'period_id' => 'bail|required|integer|exists:periods,id',
            'questionnaire_class_id' => 'bail|required|integer|exists:questionnaire_classes,id',
            'position' => 'bail|required|integer',
            'start_date' => 'bail|date',
            'end_date' => 'bail|date',
        ];
    }
}
