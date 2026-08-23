<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArenaMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'time_spent_seconds',
        'questions_data',
    ];

    protected $casts = [
        'questions_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}