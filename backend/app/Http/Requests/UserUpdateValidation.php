<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateValidation extends FormRequest
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
        $user_id = $this->route('id');
        return [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email, ' . $user_id . ',id',
            'password' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'username.required' => 'Username field is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'email.required' => 'Email field is required',
        ];
    }
}