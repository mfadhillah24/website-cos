<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_members');
    }

    public function rules(): array
    {
        $memberId = $this->route('member')->id;

        return [
            'status_id'  => ['required', 'exists:member_statuses,id'],
            'user_id'    => ['nullable', 'exists:users,id', Rule::unique('members', 'user_id')->ignore($memberId)],
            'division_id'=> ['required_if:status_id,1', 'nullable', 'exists:divisions,id'],
            'nta'        => ['nullable', 'string', 'max:60', Rule::unique('members', 'nta')->ignore($memberId)],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['nullable', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'angkatan'   => ['nullable', 'string', 'max:4'],
            'generation' => ['nullable', 'integer', 'min:1'],
            'bio'        => ['nullable', 'string'],
            'linkedin'   => ['nullable', 'string', 'max:255'],
            'github'     => ['nullable', 'string', 'max:255'],
            'is_founder' => ['nullable', 'boolean'],
            'photo'      => ['nullable', 'image', 'max:2048'],
            'status_change_notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
