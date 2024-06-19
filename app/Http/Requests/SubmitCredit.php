<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCredit extends FormRequest
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
            "name" => 'required|min:3',
            "amount" => 'required|numeric|min:2',
            "customRange" => 'required|numeric|between:3,120',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be a number.',
            'between' => 'The :attribute must be between :min and :max.',
            'min' => 'The :attribute must be at least :min.',
        ];
    }
}
