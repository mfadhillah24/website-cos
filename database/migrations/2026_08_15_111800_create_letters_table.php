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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['incoming', 'outgoing']);
            
            // Kolom umum
            $table->string('letter_number');
            $table->date('letter_date');
            $table->string('subject');
            $table->string('letter_type')->nullable(); // jenis surat
            $table->string('priority')->nullable(); // sifat surat (Biasa, Penting, Segera, Rahasia)
            $table->text('summary')->nullable(); // Ringkasan/Isi surat
            $table->string('file_path')->nullable();
            
            // Kolom Surat Masuk
            $table->date('received_date')->nullable();
            $table->string('sender')->nullable();
            $table->string('agenda_number')->nullable(); // Nomor Agenda (bisa generate otomatis)
            $table->string('destination')->nullable(); // Tujuan Surat internal
            
            // Kolom Surat Keluar
            $table->string('receiver')->nullable(); // Tujuan Eksternal
            $table->string('signer')->nullable(); // Penandatangan
            $table->string('signer_position')->nullable(); // Jabatan penandatangan
            
            // Status Tracking
            $table->string('status')->default('baru');
            // Status incoming: Baru, Diproses, Didisposisikan, Selesai, Diarsipkan
            // Status outgoing: Draft, Menunggu Persetujuan, Disetujui, Dikirim, Diarsipkan
            
            $table->text('notes')->nullable();
            
            // Relasi (pembuat data)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
