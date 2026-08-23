<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'level',
        'summary',
        'content',
        'order_index',
        'is_published',
    ];
    public function questions()
{
    return $this->hasMany(GrammarQuestion::class, 'grammar_lesson_id');
}
}
