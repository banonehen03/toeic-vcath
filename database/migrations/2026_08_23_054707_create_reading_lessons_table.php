<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reading_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('part', ['part_5', 'part_6', 'part_7']);
            $table->text('description')->nullable();
            $table->longText('passage')->nullable(); // Đoạn văn bản đọc hiểu (Part 6, Part 7)
            $table->string('image_url')->nullable();
            $table->integer('order_index')->default(1);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_lessons');
    }
};