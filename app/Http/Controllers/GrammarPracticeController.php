<?php

namespace App\Http\Controllers;

use App\Models\GrammarLesson;
use App\Models\GrammarQuestion;
use Illuminate\Http\Request;

class GrammarPracticeController extends Controller
{
    // Danh sách các chủ đề luyện tập ngữ pháp
    public function index()
    {
        $lessons = GrammarLesson::withCount('questions')
            ->where('is_published', true)
            ->orderBy('order_index', 'asc')
            ->get();

        return view('grammar_practice.index', compact('lessons'));
    }

    // Làm bài tập trắc nghiệm theo bài học
    public function practice($slug)
    {
        $lesson = GrammarLesson::where('slug', $slug)
            ->with('questions')
            ->firstOrFail();

        return view('grammar_practice.practice', compact('lesson'));
    }
}