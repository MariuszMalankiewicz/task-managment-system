<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationUserLoginRequest extends FormRequest
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
            "email"=> 'required|email|max:255',
            "password"=> 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Adres e-mail jest wymagany.',
            'email.email' => 'Adres e-mail musi być prawidłowym adresem e-mail.',
            'email.max' => 'Adres e-mail nie może mieć więcej niż 255 znaków.',
            'password.required' => 'Hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
        ];
    }
}
