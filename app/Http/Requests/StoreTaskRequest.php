<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'status' => [
                'required',
                Rule::in(['pending', 'in_progress', 'completed'])
            ],
            'user_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tytuł jest wymagany.',
            'description.required' => 'Opis jest wymagany.',
            'status.required' => 'Status jest wymagany.',
            'status.in' => 'Wybrany status nie istnieje.',
            'user_id.required' => 'Identyfikacja użytkownika jest wymagana.',
        ];
     }
}
