<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_programs');
    }

    public function rules(): array
    {
        return [
            'division_id' => ['required', 'exists:divisions,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'target' => ['nullable', 'string'],
            'status' => ['required', 'in:planning,on_progress,completed,cancelled'],
            'pic_member_id' => ['nullable', 'exists:members,id'],
        ];
    }
}
