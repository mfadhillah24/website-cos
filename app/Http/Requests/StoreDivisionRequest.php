<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_division');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:divisions,name'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
