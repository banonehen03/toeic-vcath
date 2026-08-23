<?php

namespace App\Http\Controllers;

use App\Models\ListeningLesson;
use Illuminate\Http\Request;

class ListeningController extends Controller
{
    public function index(Request $request)
    {
        $part = $request->query('part');

        $query = ListeningLesson::withCount('questions')
            ->where('is_published', true)
            ->orderBy('order_index', 'asc');

        if ($part && in_array($part, ['part_1', 'part_2', 'part_3', 'part_4'])) {
            $query->where('part', $part);
        }

        $lessons = $query->get();

        return view('listening.index', compact('lessons', 'part'));
    }

    public function practice($slug)
    {
        $lesson = ListeningLesson::where('slug', $slug)
            ->with('questions')
            ->firstOrFail();

        return view('listening.practice', compact('lesson'));
    }
}