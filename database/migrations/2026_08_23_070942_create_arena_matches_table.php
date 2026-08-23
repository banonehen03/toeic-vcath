<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arena_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('score')->default(0); // Số câu đúng (0-10)
            $table->integer('time_spent_seconds')->default(0); // Thời gian hoàn thành (giây)
            $table->json('questions_data')->nullable(); // Lưu snapshot 10 câu hỏi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arena_matches');
    }
};