<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VocabularyCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'order_index', 'is_published'];

    public function words()
    {
        return $this->hasMany(VocabularyWord::class, 'vocabulary_category_id');
    }
}