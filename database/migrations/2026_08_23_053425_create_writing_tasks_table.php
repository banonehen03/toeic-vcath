<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('writing_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('part', ['part_1', 'part_2', 'part_3']); // Part 1: Sentences, Part 2: Email, Part 3: Essay
            $table->text('prompt'); // Đề bài / Tình huống email / Đề văn
            $table->string('keywords')->nullable(); // Từ khóa bắt buộc (Part 1)
            $table->string('image_url')->nullable(); // Hình ảnh (Part 1)
            $table->integer('time_limit_minutes')->default(10);
            $table->integer('min_words')->nullable();
            $table->text('sample_response')->nullable(); // Bài viết mẫu
            $table->text('key_vocabulary')->nullable(); // Từ vựng / Cụm từ nên dùng
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('writing_tasks');
    }
};