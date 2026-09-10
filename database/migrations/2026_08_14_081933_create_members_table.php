<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('status_id')->constrained('member_statuses')->restrictOnDelete();
            $table->string('nim', 50)->unique()->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('photo')->nullable();
            $table->string('angkatan', 4)->nullable();
            $table->text('bio')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->boolean('is_founder')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
