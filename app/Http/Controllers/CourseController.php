<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;

class CourseController extends Controller
{
    // Trang danh sách khóa học
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    // Trang học bài trực tiếp
    public function learn($courseId, $lessonId)
    {
        $course = Course::with('lessons')->findOrFail($courseId);
        $currentLesson = Lesson::where('course_id', $courseId)->findOrFail($lessonId);
        return view('courses.learn', compact('course', 'currentLesson'));
    }
}