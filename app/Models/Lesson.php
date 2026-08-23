<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'video_url', 'content', 'order_number'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
}