<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidRut;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'rut' => ['sometimes', 'string', 'max:255', new ValidRut()],
            'email' => ['sometimes', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string'],
        ];
    }
}
