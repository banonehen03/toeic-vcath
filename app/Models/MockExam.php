<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExam extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'duration_minutes', 'audio_url', 'is_published'];

    public function questions()
    {
        return $this->hasMany(MockQuestion::class, 'mock_exam_id')->orderBy('question_number', 'asc');
    }

    public function results()
    {
        return $this->hasMany(MockExamResult::class, 'mock_exam_id');
    }
}