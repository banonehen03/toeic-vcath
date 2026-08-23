<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'part',
        'description',
        'audio_url',
        'image_url',
        'transcript',
        'order_index',
        'is_published',
    ];

    public function questions()
    {
        return $this->hasMany(ListeningQuestion::class, 'listening_lesson_id');
    }
}