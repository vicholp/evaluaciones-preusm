<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionRequest extends FormRequest
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
            'name' => 'bail|required|string',
            'subject_id' => 'bail|required|exists:subjects,id',
            'period_id' => 'bail|required|exists:periods,id',
            'study_plan_id' => 'bail|required|exists:study_plans,id',
        ];
    }
}
