<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mock_exam_id')->constrained('mock_exams')->onDelete('cascade');
            $table->integer('listening_correct')->default(0);
            $table->integer('reading_correct')->default(0);
            $table->integer('listening_score')->default(5); // Quy đổi thang điểm TOEIC
            $table->integer('reading_score')->default(5);
            $table->integer('total_score')->default(10);
            $table->json('user_answers')->nullable(); // Lưu các đáp án user đã chọn
            $table->integer('time_spent_seconds')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_exam_results');
    }
};