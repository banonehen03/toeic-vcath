<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamSW extends Model
{
    use HasFactory;

    protected $table = 'mock_exam_s_w_s';
    protected $fillable = ['title', 'slug', 'description', 'duration_minutes', 'is_published'];

    public function questions()
    {
        return $this->hasMany(MockQuestionSW::class, 'mock_exam_s_w_id')->orderBy('question_number', 'asc');
    }

    public function results()
    {
        return $this->hasMany(MockExamResultSW::class, 'mock_exam_s_w_id');
    }
}