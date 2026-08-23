<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'summary',
        'content',
        'thumbnail',
        'views_count',
        'is_published',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}