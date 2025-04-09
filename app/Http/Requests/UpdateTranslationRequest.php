<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
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

    public function rules()
    {
        return [
            'language_id' => 'nullable|exists:languages,id',
            'tag_id' => 'nullable|exists:tags,id',
            'key' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'language_id.exists' => 'The selected language is invalid.',
            'tag_id.exists' => 'The selected tag is invalid.',
            'key.string' => 'The translation key must be a string.',
            'value.string' => 'The translation value must be a string.',
        ];
    }
}
