<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom previous_status (untuk restore arsip) dan
     * deleted_at (untuk Soft Delete) pada tabel letters.
     */
    public function up(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            // Menyimpan status surat sebelum diarsipkan, agar bisa dikembalikan
            $table->string('previous_status')->nullable()->after('status');

            // Soft Delete — data tidak benar-benar dihapus dari database
            $table->softDeletes()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropColumn('previous_status');
            $table->dropSoftDeletes();
        });
    }
};
