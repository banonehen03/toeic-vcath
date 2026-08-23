<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listening_lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('part', ['part_1', 'part_2', 'part_3', 'part_4']);
            $table->text('description')->nullable();
            $table->string('audio_url')->nullable(); // Đường dẫn file audio
            $table->string('image_url')->nullable(); // Dùng cho Part 1 hoặc sơ đồ Part 3/4
            $table->longText('transcript')->nullable(); // Lời thoại audio
            $table->integer('order_index')->default(1);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listening_lessons');
    }
};