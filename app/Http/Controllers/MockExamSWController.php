<?php

namespace App\Http\Controllers;

use App\Models\MockExamSW;
use App\Models\MockExamResultSW;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MockExamSWController extends Controller
{
    // Danh sách đề thi S&W
    public function index()
    {
        $exams = MockExamSW::withCount('questions')
            ->where('is_published', true)
            ->get();

        $userResults = [];
        if (Auth::check()) {
            $userResults = MockExamResultSW::where('user_id', Auth::id())
                ->latest()
                ->get()
                ->keyBy('mock_exam_s_w_id');
        }

        return view('mock_tests_sw.index', compact('exams', 'userResults'));
    }

    // Giao diện phòng thi S&W
    public function take($slug)
    {
        $exam = MockExamSW::where('slug', $slug)
            ->with(['questions' => function ($q) {
                $q->orderBy('skill', 'asc')->orderBy('question_number', 'asc');
            }])
            ->firstOrFail();

        return view('mock_tests_sw.take', compact('exam'));
    }

    // Nộp bài thi
    public function submit(Request $request, $id)
    {
        $exam = MockExamSW::findOrFail($id);

        $writingAnswers = $request->input('writing_answers', []);
        $speakingRecordings = $request->input('speaking_recordings', []);

        $result = MockExamResultSW::create([
            'user_id' => Auth::id(),
            'mock_exam_s_w_id' => $exam->id,
            'speaking_recordings' => $speakingRecordings,
            'writing_answers' => $writingAnswers,
            'status' => 'submitted',
        ]);

        return redirect()->route('mock_test_sw.result', $result->id);
    }

    // Xem kết quả bài làm & Lời giải mẫu
    public function result($resultId)
    {
        $result = MockExamResultSW::with(['exam.questions', 'user'])->findOrFail($resultId);

        if ($result->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('mock_tests_sw.result', compact('result'));
    }
}