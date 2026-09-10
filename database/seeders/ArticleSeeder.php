<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@ukmitcos.org')->first();
        $categories = ArticleCategory::all();

        if (!$author || $categories->isEmpty()) {
            $this->command->warn('⚠️ ArticleSeeder: User admin atau Kategori Artikel tidak ditemukan.');
            return;
        }

        for ($i = 1; $i <= 5; $i++) {
            $title = "Judul Artikel Contoh Ke-$i " . fake()->words(3, true);
            Article::create([
                'category_id'  => $categories->random()->id,
                'author_id'    => $author->id,
                'title'        => $title,
                'slug'         => Str::slug($title) . '-' . time(),
                'excerpt'      => fake()->sentence(10),
                'content'      => '<p>' . fake()->paragraph(5) . '</p><p>' . fake()->paragraph(4) . '</p>',
                'status'       => 'published',
                'published_at' => now()->subDays(rand(1, 10)),
            ]);
        }

        $this->command->info('✅ ArticleSeeder: Artikel dummy berhasil di-seed.');
    }
}
