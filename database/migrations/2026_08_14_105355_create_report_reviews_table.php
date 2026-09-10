<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('division_reports')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->text('notes');
            $table->enum('action', ['approved', 'revision']); // what the reviewer decided
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_reviews');
    }
};
