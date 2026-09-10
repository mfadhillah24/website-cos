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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->nullable(); // Rapat, Kegiatan organisasi, dll
            
            $table->date('agenda_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            
            $table->string('location')->nullable();
            $table->string('pic')->nullable(); // Penanggung jawab
            $table->string('participants')->nullable(); // Peserta (bisa berupa teks misal: "Semua Pengurus")
            
            $table->text('description')->nullable();
            
            $table->string('status')->default('terjadwal');
            
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
