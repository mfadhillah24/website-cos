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
        Schema::create('rabs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('activity_name');
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->date('date');
            $table->string('pic_name');
            $table->string('pic_position');
            $table->text('description')->nullable();
            $table->string('status')->default('draft'); // draft, final
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rabs');
    }
};
