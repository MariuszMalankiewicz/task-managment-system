<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationUserRegisterRequest extends FormRequest
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
            "name"=> 'required|min:4|max:255',
            "email"=> 'required|email|max:255|unique:users',
            "password"=> 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nazwa jest wymagana.',
            'name.min' => 'Nazwa nie może mieć mniej niż 4 znaki.',
            'name.max' => 'Nazwa nie może mieć więcej niż 255 znaków.',
            'email.required' => 'Adres e-mail jest wymagany.',
            'email.email' => 'Adres e-mail musi być prawidłowym adresem e-mail.',
            'email.max' => 'Adres e-mail nie może mieć więcej niż 255 znaków.',
            'email.unique' => 'Podany adres e-mail jest już zajęty.',
            'password.required' => 'Hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
        ];
    }
}
