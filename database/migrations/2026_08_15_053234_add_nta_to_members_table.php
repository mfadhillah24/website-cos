<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Nomor Induk Anggota — hanya untuk Anggota Tetap
            // Format: COS.UNITAMA.{ANGKATAN_ROMAWI}.{NOMOR_URUT}.{PERIODE}
            $table->string('nta', 60)->nullable()->unique()->after('nim');
            // Angkatan UKM (generasi ke-berapa), berbeda dengan tahun angkatan mahasiswa
            $table->unsignedSmallInteger('generation')->nullable()->after('angkatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['nta', 'generation']);
        });
    }
};
