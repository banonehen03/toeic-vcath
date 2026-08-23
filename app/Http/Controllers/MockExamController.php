<?php

namespace App\Http\Controllers;

use App\Models\MockExam;
use App\Models\MockExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MockExamController extends Controller
{
    // Danh sách các đề thi
    public function index()
    {
        $exams = MockExam::withCount('questions')
            ->where('is_published', true)
            ->get();

        $userResults = [];
        if (Auth::check()) {
            $userResults = MockExamResult::where('user_id', Auth::id())
                ->latest()
                ->get()
                ->keyBy('mock_exam_id');
        }

        return view('mock_tests.index', compact('exams', 'userResults'));
    }

    // Màn hình làm bài thi
    public function take($slug)
    {
        $exam = MockExam::where('slug', $slug)
            ->with(['questions' => function ($q) {
                $q->orderBy('question_number', 'asc');
            }])
            ->firstOrFail();

        return view('mock_tests.take', compact('exam'));
    }

    // Nộp bài thi và chấm điểm
    public function submit(Request $request, $id)
    {
        $exam = MockExam::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $timeSpent = (int) $request->input('time_spent_seconds', 0);

        $listeningCorrect = 0;
        $readingCorrect = 0;

        foreach ($exam->questions as $q) {
            $userAns = $answers[$q->id] ?? null;
            if ($userAns && strtoupper($userAns) === strtoupper($q->correct_answer)) {
                if ($q->section === 'listening') {
                    $listeningCorrect++;
                } else {
                    $readingCorrect++;
                }
            }
        }

        // Quy đổi điểm TOEIC mẫu cơ bản
        $listeningScore = min(495, max(5, $listeningCorrect * 50)); 
        $readingScore = min(495, max(5, $readingCorrect * 50));
        $totalScore = $listeningScore + $readingScore;

        $result = MockExamResult::create([
            'user_id' => Auth::id(),
            'mock_exam_id' => $exam->id,
            'listening_correct' => $listeningCorrect,
            'reading_correct' => $readingCorrect,
            'listening_score' => $listeningScore,
            'reading_score' => $readingScore,
            'total_score' => $totalScore,
            'user_answers' => $answers,
            'time_spent_seconds' => $timeSpent,
        ]);

        return redirect()->route('mock_test.result', $result->id);
    }

    // Xem kết quả chi tiết
    public function result($resultId)
    {
        $result = MockExamResult::with(['exam.questions', 'user'])->findOrFail($resultId);

        if ($result->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('mock_tests.result', compact('result'));
    }
}