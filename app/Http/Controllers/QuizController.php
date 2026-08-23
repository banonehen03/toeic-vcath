<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('quiz.index', compact('questions'));
    }

    public function submit(Request $request)
    {
        $userAnswers = $request->input('answers', []);
        $questions = Question::all();

        $score = 0;
        $total = $questions->count();
        $results = [];

        foreach ($questions as $q) {
            $chosen = $userAnswers[$q->id] ?? null;
            $isCorrect = ($chosen === $q->correct_option);
            if ($isCorrect) {
                $score++;
            }

            $results[] = [
                'question' => $q->question_text,
                'chosen' => $chosen,
                'correct' => $q->correct_option,
                'isCorrect' => $isCorrect,
                'explanation' => $q->explanation,
            ];
        }

        $percentage = $total > 0 ? (int)round(($score / $total) * 100) : 0;

        // Lưu kết quả bài làm vào Database
        if (Auth::check()) {
            QuizResult::create([
                'user_id' => Auth::id(),
                'score' => $score,
                'total_questions' => $total,
                'percentage' => $percentage,
            ]);
        }

        return view('quiz.result', compact('score', 'total', 'percentage', 'results'));
    }
}