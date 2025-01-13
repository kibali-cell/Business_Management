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
       // Check if the 'file_size' column exists before adding it
    if (!Schema::hasColumn('documents', 'file_size')) {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('file_size')->nullable()->after('path');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
    }
};
