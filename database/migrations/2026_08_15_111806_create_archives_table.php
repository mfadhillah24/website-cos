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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama dokumen
            $table->string('category'); // Surat Masuk, Surat Keluar, SK, Proposal, LPJ, Notulen, dll
            
            $table->string('document_number')->nullable(); // Nomor dokumen
            $table->date('document_date')->nullable();
            
            $table->text('description')->nullable();
            
            $table->string('file_path'); // Path file
            $table->string('status')->default('active'); // active, archived
            
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
