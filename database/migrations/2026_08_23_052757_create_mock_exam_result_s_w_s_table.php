<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_exam_result_s_w_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mock_exam_s_w_id')->constrained('mock_exam_s_w_s')->onDelete('cascade');
            $table->json('speaking_recordings')->nullable(); // Lưu đường dẫn file audio người dùng ghi âm
            $table->json('writing_answers')->nullable(); // Lưu bài viết của người dùng
            $table->integer('speaking_score')->nullable(); // Giảng viên chấm (thang 200)
            $table->integer('writing_score')->nullable(); // Giảng viên chấm (thang 200)
            $table->text('teacher_feedback')->nullable(); // Lời nhận xét
            $table->enum('status', ['submitted', 'graded'])->default('submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_exam_result_s_w_s');
    }
};