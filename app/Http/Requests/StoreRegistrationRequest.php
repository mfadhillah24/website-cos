<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Anyone can register
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'nim'           => ['required', 'string', 'max:20', 'unique:registrations,nim'],
            'study_program' => ['required', 'string', 'max:255'],
            'batch_year'    => ['required', 'string', 'max:4'],
            'email'         => ['required', 'email', 'max:255'],
            'phone'         => ['required', 'string', 'max:20'],
            'birth_place'   => ['required', 'string', 'max:255'],
            'birth_date'    => ['required', 'date'],
            'address'       => ['required', 'string'],
            'division_id'   => ['required', 'exists:divisions,id'],
            'reason'        => ['required', 'string'],
        ];
    }
}
