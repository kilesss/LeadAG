<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakePayment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "credit" => 'required',
            "amount" => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be a number.',
        ];
    }
}
