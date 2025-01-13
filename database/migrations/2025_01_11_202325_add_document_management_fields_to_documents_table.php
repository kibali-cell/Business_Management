<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'task_id')) {
                $table->foreignId('task_id')->nullable()->change();
            }

            if (!Schema::hasColumn('documents', 'title')) {
                $table->string('title')->after('id');
            }

            if (!Schema::hasColumn('documents', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (!Schema::hasColumn('documents', 'file_type')) {
                $table->string('file_type')->after('path');
            }

            if (!Schema::hasColumn('documents', 'file_size')) {
                $table->integer('file_size')->after('file_type');
            }

            if (!Schema::hasColumn('documents', 'folder_id')) {
                $table->foreignId('folder_id')->nullable()->after('task_id')
                    ->constrained('folders')->nullOnDelete();
            }

            if (!Schema::hasColumn('documents', 'is_public')) {
                $table->boolean('is_public')->default(false)->after('folder_id');
            }

            if (!Schema::hasColumn('documents', 'version')) {
                $table->integer('version')->default(1)->after('is_public');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'title')) {
                $table->dropColumn('title');
            }

            if (Schema::hasColumn('documents', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('documents', 'file_type')) {
                $table->dropColumn('file_type');
            }

            if (Schema::hasColumn('documents', 'file_size')) {
                $table->dropColumn('file_size');
            }

            if (Schema::hasColumn('documents', 'folder_id')) {
                $table->dropForeign(['folder_id']);
                $table->dropColumn('folder_id');
            }

            if (Schema::hasColumn('documents', 'is_public')) {
                $table->dropColumn('is_public');
            }

            if (Schema::hasColumn('documents', 'version')) {
                $table->dropColumn('version');
            }
        });
    }
};
