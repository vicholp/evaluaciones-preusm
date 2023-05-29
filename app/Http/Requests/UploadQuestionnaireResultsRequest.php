<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadQuestionnaireResultsRequest extends FormRequest
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
            'file_stats' => '',
            'file_tags' => '',
            'file_answers' => '',
            'file_formscanner' => '',
            'questionnaire_id' => 'required|exists:questionnaires,id',
        ];
    }
}
