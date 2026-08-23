<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocabulary_words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocabulary_category_id')->constrained('vocabulary_categories')->onDelete('cascade');
            $table->string('word');
            $table->string('phonetic')->nullable(); // Phiên âm IPA (/kənˈtrækt/)
            $table->string('part_of_speech')->nullable(); // n, v, adj, adv
            $table->text('meaning_vi'); // Nghĩa tiếng Việt
            $table->text('meaning_en')->nullable(); // Định nghĩa tiếng Anh
            $table->text('example_sentence')->nullable(); // Câu ví dụ
            $table->text('example_translation')->nullable(); // Dịch câu ví dụ
            $table->string('image_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vocabulary_words');
    }
};