<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'price', 'level'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order_number', 'asc');
    }
    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
}