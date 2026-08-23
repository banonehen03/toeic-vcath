<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'mock_exam_id',
        'section',
        'part_number',
        'question_number',
        'question_text',
        'image_url',
        'audio_url',
        'passage',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
    ];

    public function exam()
    {
        return $this->belongsTo(MockExam::class, 'mock_exam_id');
    }
}