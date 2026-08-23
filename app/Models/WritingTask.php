<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WritingTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'part',
        'prompt',
        'keywords',
        'image_url',
        'time_limit_minutes',
        'min_words',
        'sample_response',
        'key_vocabulary',
        'is_published',
    ];

    public function submissions()
    {
        return $this->hasMany(WritingSubmission::class, 'writing_task_id');
    }
}