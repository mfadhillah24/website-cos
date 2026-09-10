<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Berita Organisasi', 'description' => 'Informasi terbaru tentang kegiatan internal COS.'],
            ['name' => 'Teknologi & Informasi', 'description' => 'Artikel mengenai perkembangan teknologi terbaru.'],
            ['name' => 'Tutorial IT', 'description' => 'Panduan dan tutorial seputar dunia IT.'],
        ];

        foreach ($categories as $category) {
            ArticleCategory::create($category);
        }

        $this->command->info('✅ ArticleCategorySeeder: Kategori artikel berhasil di-seed.');
    }
}
