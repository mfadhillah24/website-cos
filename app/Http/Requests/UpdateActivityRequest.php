<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_activities');
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content'     => ['nullable', 'string'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'program_id'  => ['nullable', 'exists:programs,id'],
            'thumbnail'   => ['nullable', 'image', 'max:2048'],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'location'    => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'in:draft,published,completed'],
            'photos.*'    => ['nullable', 'image', 'max:2048'],
        ];
    }
}
