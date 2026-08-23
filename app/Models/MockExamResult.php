<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mock_exam_id',
        'listening_correct',
        'reading_correct',
        'listening_score',
        'reading_score',
        'total_score',
        'user_answers',
        'time_spent_seconds',
    ];

    protected $casts = [
        'user_answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(MockExam::class, 'mock_exam_id');
    }
}