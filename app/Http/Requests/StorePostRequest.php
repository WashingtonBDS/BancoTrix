<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'name' => 'required|string|max:255|min:3',
                'document_type' => 'required|string',
                'document_number' => 'required|numeric|unique:users,document_number|digits_between:11,14',
                'email' => [
                    'required',
                    'email',
                    'unique:users,email'
                ],
                'password' => [
                    'required',
                    'min:6',
                    'max:15',
                ],
            ];
        }

        public function messages()
        {
            return [
                'name.required' => 'Required name, minimum 3 letters',
                'document_number.unique' => 'The document field is invalid, it has already been entered in the system',
                'email.unique' => 'The email field is invalid, it has already been entered in the systema',
                'document_type.required' => 'Select [CPF] or [CNPJ]',
                'document_number.required' => 'Enter the number [CPF] or [CNPJ]',
                'email.required' => 'Email is required, EX: user@email.com',
                'password.required' => 'password. min:6 max:15 characters'
        ];
    }
}
