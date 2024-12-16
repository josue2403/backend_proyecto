<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'ci' => 'required|unique:users,ci|max:20',
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'rol_id' => 'required|exists:rol,id',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'required|date',
            'country' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:30',
            'urlPhoto' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
