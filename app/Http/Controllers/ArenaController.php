<?php

namespace App\Http\Controllers;

use App\Models\ArenaMatch;
use App\Models\GrammarQuestion;
use App\Models\ReadingQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArenaController extends Controller
{
    // Trang chủ Đấu trường & Bảng xếp hạng tuần
    public function index()
    {
        $topPlayers = ArenaMatch::with('user')
            ->orderByDesc('score')
            ->orderBy('time_spent_seconds', 'asc')
            ->take(10)
            ->get();

        $myBest = null;
        if (Auth::check()) {
            $myBest = ArenaMatch::where('user_id', Auth::id())
                ->orderByDesc('score')
                ->orderBy('time_spent_seconds', 'asc')
                ->first();
        }

        return view('arena.index', compact('topPlayers', 'myBest'));
    }

    // Bắt đầu trận đấu 10 câu ngẫu nhiên
    public function play()
    {
        // Lấy ngẫu nhiên 10 câu hỏi từ Grammar / Reading
        $grammarQ = GrammarQuestion::inRandomOrder()->take(5)->get();
        $readingQ = ReadingQuestion::inRandomOrder()->take(5)->get();

        $questions = $grammarQ->concat($readingQ)->shuffle()->values();

        if ($questions->count() === 0) {
            return redirect()->route('arena.index')->with('error', 'Chưa đủ dữ liệu câu hỏi để tạo đấu trường.');
        }

        return view('arena.play', compact('questions'));
    }

    // Nộp kết quả trận đấu
    public function submit(Request $request)
    {
        $userAnswers = $request->input('answers', []);
        $questionsData = $request->input('questions_payload', []);
        $timeSpent = (int) $request->input('time_spent', 0);

        $score = 0;
        foreach ($questionsData as $q) {
            $qId = $q['id'];
            $correct = $q['correct_answer'];
            if (isset($userAnswers[$qId]) && strtoupper($userAnswers[$qId]) === strtoupper($correct)) {
                $score++;
            }
        }

        $match = ArenaMatch::create([
            'user_id' => Auth::id(),
            'score' => $score,
            'time_spent_seconds' => $timeSpent,
            'questions_data' => $questionsData,
        ]);

        return response()->json([
            'success' => true,
            'score' => $score,
            'total' => count($questionsData),
            'time_spent' => $timeSpent,
            'redirect_url' => route('arena.index'),
        ]);
    }
}