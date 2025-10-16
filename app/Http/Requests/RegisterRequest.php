<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed',  Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'   => 'The username field is required.',
            'name.unique'     => 'This username is already taken.',
            'email.required'      => 'The email field is required.',
            'email.email'         => 'The email format is invalid.',
            'email.unique'        => 'This email is already registered.',
            'password.required'   => 'The password field is required.',
            'password.min'        => 'The password must be at least 8 characters.',
            'password.confirmed'  => 'Password confirmation does not match.',
        ];
    }
}
