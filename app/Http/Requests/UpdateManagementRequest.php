<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_management');
    }

    public function rules(): array
    {
        return [
            'member_id' => [
                'required',
                'exists:members,id',
                Rule::unique('managements')->where(function ($query) {
                    return $query->where('period_id', $this->period_id)
                                 ->where('position_id', $this->position_id);
                })->ignore($this->route('management')),
            ],
            'period_id' => ['required', 'exists:periods,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'started_at' => ['required', 'date'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'member_id.unique' => 'Anggota ini sudah menjabat di posisi tersebut pada periode yang dipilih.',
        ];
    }
}
