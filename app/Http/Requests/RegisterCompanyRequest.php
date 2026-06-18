<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function company(): array
    {
        return [
            'company_name' => $this->input('company_name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'address' => $this->input('address'),
        ];
    }

    public function userData(): array
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('user_email'),
            'password' => $this->input('password'),
        ];
    }
}
