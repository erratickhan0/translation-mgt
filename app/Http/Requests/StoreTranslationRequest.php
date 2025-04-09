<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationRequest extends FormRequest
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
            'language_id' => 'required|exists:languages,id',
            'tag_id' => 'required|exists:tags,id',
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:1000',
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
            'language_id.required' => 'The language is required.',
            'language_id.exists' => 'The selected language is invalid.',
            'tag_id.required' => 'The tag is required.',
            'tag_id.exists' => 'The selected tag is invalid.',
            'key.required' => 'The translation key is required.',
            'value.required' => 'The translation value is required.',
        ];
    }

}
