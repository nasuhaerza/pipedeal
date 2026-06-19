<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deal_id' => ['required', 'exists:deals,id'],
            'followup_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
