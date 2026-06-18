<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => [
                'required',
                Rule::exists('clients', 'id')->where(function ($query) {
                    $query->where('company_id', auth()->user()->company_id);
                }),
            ],
            'stage_id' => ['required', 'exists:pipeline_stages,id'],
            'deal_name' => ['required', 'string', 'max:255'],
            'deal_value' => ['required', 'numeric', 'min:0'],
            'expected_close_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
