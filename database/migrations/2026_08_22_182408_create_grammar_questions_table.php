<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grammar_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_lesson_id')->constrained('grammar_lessons')->onDelete('cascade');
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('correct_answer', 1); // 'A', 'B', 'C', 'D'
            $table->text('explanation')->nullable(); // Lời giải thích đáp án
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grammar_questions');
    }
};