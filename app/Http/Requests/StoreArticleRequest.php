<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_news');
    }

    public function rules(): array
    {
        return [
            'category_id'        => ['required', 'exists:article_categories,id'],
            'title'              => ['required', 'string', 'max:255'],
            'excerpt'            => ['nullable', 'string'],
            'content'            => ['required', 'string'],
            'thumbnail'          => ['nullable', 'image', 'max:2048'],
            'status'             => ['required', 'in:draft,published'],
            'gallery_images'     => ['nullable', 'array', 'max:10'],
            'gallery_images.*'   => ['nullable', 'image', 'max:10240'],
            'cover_image_index'  => ['nullable', 'integer'],
            'gallery_captions.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required'   => 'Kategori wajib dipilih.',
            'category_id.exists'     => 'Kategori yang dipilih tidak valid.',
            'title.required'         => 'Judul artikel wajib diisi.',
            'title.max'              => 'Judul artikel maksimal 255 karakter.',
            'content.required'       => 'Konten artikel wajib diisi.',
            'thumbnail.image'        => 'Thumbnail harus berupa gambar.',
            'thumbnail.max'          => 'Ukuran thumbnail maksimal 2 MB.',
            'status.required'        => 'Status artikel wajib dipilih.',
            'status.in'              => 'Status artikel tidak valid.',
            'gallery_images.max'     => 'Maksimal hanya 10 foto yang dapat diunggah.',
            'gallery_images.*.image' => 'Setiap file galeri harus berupa gambar.',
            'gallery_images.*.max'   => 'Ukuran setiap gambar galeri maksimal 10 MB.',
            'gallery_captions.*.max' => 'Keterangan gambar maksimal 255 karakter.',
        ];
    }
}
