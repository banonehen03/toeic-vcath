<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_word_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vocabulary_word_id')->constrained('vocabulary_words')->onDelete('cascade');
            $table->boolean('is_memorized')->default(false); // Đã thuộc hay chưa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_word_progresses');
    }
};