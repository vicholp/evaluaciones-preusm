<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidRut;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'rut' => ['required', 'string', 'max:255', new ValidRut()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,rut'],
            'password' => ['required', 'string'],
        ];
    }
}
