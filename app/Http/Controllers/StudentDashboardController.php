<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\QuizResult;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $savedVocabCount = Vocabulary::where('user_id', $userId)->count();
        $quizResults = QuizResult::where('user_id', $userId)->latest()->take(5)->get();
        $courses = Course::withCount('lessons')->get();

        $averageScore = QuizResult::where('user_id', $userId)->avg('percentage') ?? 0;

        return view('student.dashboard', compact('savedVocabCount', 'quizResults', 'courses', 'averageScore'));
    }
}