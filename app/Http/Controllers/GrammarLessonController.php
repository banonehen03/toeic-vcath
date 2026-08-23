<?php

namespace App\Http\Controllers;

use App\Models\GrammarLesson;
use Illuminate\Http\Request;

class GrammarLessonController extends Controller
{
    public function index()
    {
        $lessons = GrammarLesson::where('is_published', true)
            ->orderBy('order_index', 'asc')
            ->get();

        return view('grammar.index', compact('lessons'));
    }

    public function show($slug)
    {
        $lesson = GrammarLesson::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $previousLesson = GrammarLesson::where('order_index', '<', $lesson->order_index)
            ->where('is_published', true)
            ->orderBy('order_index', 'desc')
            ->first();

        $nextLesson = GrammarLesson::where('order_index', '>', $lesson->order_index)
            ->where('is_published', true)
            ->orderBy('order_index', 'asc')
            ->first();

        return view('grammar.show', compact('lesson', 'previousLesson', 'nextLesson'));
    }
}