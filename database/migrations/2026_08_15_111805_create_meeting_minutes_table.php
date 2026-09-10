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
        Schema::create('meeting_minutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            
            $table->string('leader')->nullable(); // Pimpinan rapat
            $table->string('notulist')->nullable(); // Notulis
            
            $table->text('discussion_results'); // Hasil pembahasan
            $table->text('decisions')->nullable(); // Keputusan rapat
            
            $table->text('follow_up')->nullable(); // Tindak lanjut
            $table->date('follow_up_deadline')->nullable(); // Deadline tindak lanjut
            
            $table->string('attachment_path')->nullable(); // File lampiran notulen (absensi dll)
            
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_minutes');
    }
};
