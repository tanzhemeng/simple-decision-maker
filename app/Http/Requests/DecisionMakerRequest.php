<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DecisionMakerRequest extends FormRequest
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
            'question' => 'required',
            'count' => 'required|numeric|min:2|max:10',
            'choices' => 'required|array|min:2|max:10',
            'choices.*' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required.',
            'numeric' => ':attribute must be a number.',
            'array' => ':attribute must be an list.',
            'numeric.min' => ':attribute must be at least :min.',
            'numeric.max' => ':attribute must not be greater than :max.',
            'array.min' => ':attribute must have at least :min items.',
            'array.max' => ':attribute must not have more than :max items.',
        ];
    }

    public function attributes(): array
    {
        return [
            'question' => 'What is your question?',
            'count' => 'How many choices?',
            'choices' => 'What are your choices?',
            'choices.*' => 'What are your choices?',
        ];
    }
}
