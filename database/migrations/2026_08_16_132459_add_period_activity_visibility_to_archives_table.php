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
        Schema::table('archives', function (Blueprint $table) {
            $table->foreignId('period_id')->nullable()->constrained('periods')->nullOnDelete()->after('category');
            $table->foreignId('activity_id')->nullable()->constrained('activities')->nullOnDelete()->after('period_id');
            $table->enum('visibility', ['public', 'internal', 'restricted'])->default('internal')->after('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->dropForeign(['period_id']);
            $table->dropForeign(['activity_id']);
            $table->dropColumn(['period_id', 'activity_id', 'visibility', 'deleted_at']);
        });
    }
};
