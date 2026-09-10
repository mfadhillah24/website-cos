<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Perbarui semua slug berita lama yang menggunakan format: judul-angka
     * Menjadi slug bersih berdasarkan judul tanpa angka timestamp di belakang.
     *
     * Jika terdapat slug duplikat (judul sama), tambahkan suffix -2, -3, dst.
     */
    public function up(): void
    {
        $articles = DB::table('articles')->orderBy('id')->get(['id', 'title', 'slug']);

        $usedSlugs = [];

        foreach ($articles as $article) {
            $baseSlug = Str::slug($article->title);

            // Pastikan slug unik di antara artikel yang diproses
            $slug = $baseSlug;
            $counter = 2;
            while (in_array($slug, $usedSlugs)) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $usedSlugs[] = $slug;

            DB::table('articles')
                ->where('id', $article->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Rollback tidak perlu mengembalikan slug lama (tidak dapat dikembalikan
     * karena timestamp sudah hilang). down() dibiarkan kosong secara sengaja.
     */
    public function down(): void
    {
        // Tidak ada rollback karena slug lama berbasis timestamp tidak
        // dapat dipulihkan secara otomatis.
    }
};
