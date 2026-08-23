<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockQuestionSW extends Model
{
    use HasFactory;

    protected $table = 'mock_question_s_w_s';
    protected $fillable = [
        'mock_exam_s_w_id',
        'skill',
        'question_number',
        'task_type',
        'prompt',
        'image_url',
        'audio_url',
        'prep_time_seconds',
        'response_time_seconds',
        'min_words',
        'sample_answer',
    ];

    public function exam()
    {
        return $this->belongsTo(MockExamSW::class, 'mock_exam_s_w_id');
    }
}