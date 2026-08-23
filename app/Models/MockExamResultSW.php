<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamResultSW extends Model
{
    use HasFactory;

    protected $table = 'mock_exam_result_s_w_s';
    protected $fillable = [
        'user_id',
        'mock_exam_s_w_id',
        'speaking_recordings',
        'writing_answers',
        'speaking_score',
        'writing_score',
        'teacher_feedback',
        'status',
    ];

    protected $casts = [
        'speaking_recordings' => 'array',
        'writing_answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(MockExamSW::class, 'mock_exam_s_w_id');
    }
}