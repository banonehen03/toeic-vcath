<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_exam_id')->constrained('mock_exams')->onDelete('cascade');
            $table->enum('section', ['listening', 'reading']);
            $table->integer('part_number'); // Part 1 -> 7
            $table->integer('question_number'); // Số thứ tự từ câu 1 -> 200
            $table->text('question_text')->nullable();
            $table->string('image_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->text('passage')->nullable(); // Đoạn văn đọc hiểu (Part 6, 7)
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d')->nullable();
            $table->string('correct_answer', 1);
            $table->text('explanation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_questions');
    }
};