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
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'folder_id')) {
                $table->foreignId('folder_id')->nullable()->constrained('folders')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'folder_id')) {
                $table->dropForeign(['folder_id']);
                $table->dropColumn('folder_id');
            }
        });
    }
};
