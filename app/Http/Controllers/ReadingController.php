<?php

namespace App\Http\Controllers;

use App\Models\ReadingLesson;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function index(Request $request)
    {
        $part = $request->query('part');

        $query = ReadingLesson::withCount('questions')
            ->where('is_published', true)
            ->orderBy('order_index', 'asc');

        if ($part && in_array($part, ['part_5', 'part_6', 'part_7'])) {
            $query->where('part', $part);
        }

        $lessons = $query->get();

        return view('reading.index', compact('lessons', 'part'));
    }

    public function practice($slug)
    {
        $lesson = ReadingLesson::where('slug', $slug)
            ->with('questions')
            ->firstOrFail();

        return view('reading.practice', compact('lesson'));
    }
}