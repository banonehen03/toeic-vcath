<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWordProgress extends Model
{
    use HasFactory;

    protected $table = 'user_word_progress';

    protected $fillable = [
        'user_id',
        'vocabulary_id',
        'is_memorized',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class);
    }
}