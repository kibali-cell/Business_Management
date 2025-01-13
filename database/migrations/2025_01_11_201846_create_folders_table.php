<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('path')->nullable(); // Stores full path like "root/folder1/folder2"
            $table->unsignedInteger('level')->default(0); // Depth level in hierarchy
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('folders')
                  ->onDelete('cascade');
            
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('folders');
    }
};