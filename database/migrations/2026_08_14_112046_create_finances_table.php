<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('finance_categories')->cascadeOnDelete();
            $table->date('date');
            $table->string('description');
            $table->integer('amount'); // in IDR, so integer is fine (no cents usually)
            $table->enum('type', ['income', 'expense']); // Denormalized for easier querying
            $table->string('receipt_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
