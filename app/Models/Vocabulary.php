<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $fillable = [
        'user_id',
        'word',
        'ipa',
        'meaning',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}