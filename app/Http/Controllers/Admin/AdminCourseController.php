<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCourseController extends Controller
{
    // Danh sách khóa học
    public function index()
    {
        $courses = Course::withCount(['lessons', 'enrollments'])
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    // Giao diện tạo khóa học mới
    public function create()
    {
        return view('admin.courses.create');
    }

    // Lưu khóa học mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|url',
            'level' => 'nullable|string',
        ]);

        Course::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
            'price' => $request->price ?? 0,
            'thumbnail' => $request->thumbnail,
            'level' => $request->level ?? 'All Levels',
            'is_published' => true,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Đã tạo khóa học mới thành công!');
    }

    // Giao diện thêm bài học vào khóa học
    public function addLesson(Course $course)
    {
        $course->load('lessons');
        return view('admin.lessons.create', compact('course'));
    }

    // Lưu bài học mới
    public function storeLesson(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'content' => 'nullable|string',
        ]);

        $nextOrder = $course->lessons()->max('order_index') + 1;

        $course->lessons()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'video_url' => $request->video_url,
            'duration' => $request->duration ?? 10,
            'content' => $request->content,
            'order_index' => $nextOrder,
            'is_preview' => $request->has('is_preview'),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Đã thêm bài học vào khóa "' . $course->title . '" thành công!');
    }
}