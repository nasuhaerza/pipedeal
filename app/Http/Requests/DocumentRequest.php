<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'deal_id' => ['required', 'exists:deals,id'],
            'file_name' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];

        if ($this->isMethod('post')) {
            $rules['file'] = ['required', 'file', 'max:10240'];
        } else {
            $rules['file'] = ['sometimes', 'file', 'max:10240'];
        }

        return $rules;
    }
}
