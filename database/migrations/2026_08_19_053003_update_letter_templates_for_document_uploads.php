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
        Schema::table('letter_templates', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('file_extension')->nullable()->after('file_name');
            $table->string('mime_type')->nullable()->after('file_extension');
            $table->unsignedBigInteger('file_size')->nullable()->after('mime_type');
            $table->longText('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_templates', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'file_extension', 'mime_type', 'file_size']);
            $table->longText('content')->nullable(false)->change();
        });
    }
};
