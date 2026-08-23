<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_question_s_w_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_exam_s_w_id')->constrained('mock_exam_s_w_s')->onDelete('cascade');
            $table->enum('skill', ['speaking', 'writing']);
            $table->integer('question_number'); // Speaking: 1-11 | Writing: 1-8
            $table->string('task_type'); // ví dụ: Read a text aloud, Describe a picture, Write an essay...
            $table->text('prompt'); // Đề bài / Văn bản cần đọc / Chủ đề bài luận
            $table->string('image_url')->nullable(); // Ảnh mô tả (Describe picture)
            $table->string('audio_url')->nullable(); // Audio đề bài phát nếu có
            $table->integer('prep_time_seconds')->default(45); // Thời gian chuẩn bị
            $table->integer('response_time_seconds')->default(45); // Thời gian nói/viết
            $table->integer('min_words')->nullable(); // Số từ tối thiểu cho Writing (300 words cho essay)
            $table->text('sample_answer')->nullable(); // Câu trả lời mẫu band điểm cao
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_question_s_w_s');
    }
};