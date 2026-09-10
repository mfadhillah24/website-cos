<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_news');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:article_categories,name,' . $this->route('article_category')->id],
            'description' => ['nullable', 'string'],
        ];
    }
}
