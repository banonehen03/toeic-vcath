<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WritingSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'writing_task_id',
        'content',
        'word_count',
        'feedback',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(WritingTask::class, 'writing_task_id');
    }
}