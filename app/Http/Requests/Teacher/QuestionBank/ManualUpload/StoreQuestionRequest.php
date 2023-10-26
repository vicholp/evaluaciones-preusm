<?php

namespace App\Http\Requests\Teacher\QuestionBank\ManualUpload;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'body' => 'string',
            'answer' => 'string',
            'solution' => ['nullable', 'string'],
            'tags' => 'array',
        ];
    }

    protected function prepareForValidation(): void
    {
        $mergedTags = collect();

        foreach ($this->tags as $tags) {
            $decodedTags = json_decode($tags);
            if ($decodedTags) {
                $mergedTags = $mergedTags->merge($decodedTags);
            }
        }

        $this->merge([
            'tags' => $mergedTags->toArray(),
        ]);
    }

    protected function passedValidation(): void
    {
        $this->merge(['tags' => collect($this->tags)]); // @phpstan-ignore-line
    }
}
