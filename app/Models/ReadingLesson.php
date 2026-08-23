<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'part',
        'description',
        'passage',
        'image_url',
        'order_index',
        'is_published',
    ];

    public function questions()
    {
        return $this->hasMany(ReadingQuestion::class, 'reading_lesson_id');
    }
}