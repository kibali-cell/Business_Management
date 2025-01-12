<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Make task_id nullable since not all documents will be task-related
            $table->foreignId('task_id')->nullable()->change();
            
            // Add new fields for document management
            $table->string('title')->after('id');
            $table->text('description')->nullable()->after('title');
            $table->string('file_type')->after('path');
            $table->integer('file_size')->after('file_type');
            $table->foreignId('folder_id')->nullable()->after('task_id')
                  ->constrained('folders')->nullOnDelete();
            $table->boolean('is_public')->default(false)->after('folder_id');
            $table->integer('version')->default(1)->after('is_public');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Instead of setting to 0, we'll drop the foreign key first
            $table->dropForeign(['task_id']);
            
            // Then make the column NOT NULL with a default value
            $table->foreignId('task_id')->nullable(false)->change();
            
            $table->dropColumn([
                'title',
                'description',
                'file_type',
                'file_size',
                'folder_id',
                'is_public',
                'version',
            ]);
        });
    }
};