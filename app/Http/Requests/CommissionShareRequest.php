<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommissionShareRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deal_id' => [
                'required',
                Rule::exists('deals', 'id')->where(function ($query) {
                    $query->where('company_id', auth()->user()->company_id);
                }),
            ],
            'recipient_name' => ['required', 'string', 'max:255'],
            'commission_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
