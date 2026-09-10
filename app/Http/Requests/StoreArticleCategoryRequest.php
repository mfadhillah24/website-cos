<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_news');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:article_categories,name'],
            'description' => ['nullable', 'string'],
        ];
    }
}
