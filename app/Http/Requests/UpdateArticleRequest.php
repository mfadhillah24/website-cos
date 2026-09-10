<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_news');
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:article_categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'excerpt'     => ['nullable', 'string'],
            'content'     => ['required', 'string'],
            'thumbnail'        => ['nullable', 'image', 'max:2048'],
            'status'           => ['required', 'in:draft,published'],
            'gallery_images'   => ['nullable', 'array', 'max:10'],
            'gallery_images.*' => ['nullable', 'image', 'max:10240'],
            'cover_image_index' => ['nullable', 'integer'],
            'gallery_captions.*' => ['nullable', 'string', 'max:255'],
            'deleted_images' => ['nullable', 'array'],
            'deleted_images.*' => ['integer'],
            'existing_captions' => ['nullable', 'array'],
            'existing_captions.*' => ['nullable', 'string', 'max:255'],
            'cover_image_id' => ['nullable', 'integer'],
        ];
    }
}
