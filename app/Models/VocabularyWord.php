<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VocabularyWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vocabulary_category_id',
        'word',
        'phonetic',
        'part_of_speech',
        'meaning_vi',
        'meaning_en',
        'example_sentence',
        'example_translation',
        'image_url',
        'audio_url',
    ];

    public function category()
    {
        return $this->belongsTo(VocabularyCategory::class, 'vocabulary_category_id');
    }

    public function progresses()
    {
        return $this->hasMany(UserWordProgress::class, 'vocabulary_word_id');
    }
}