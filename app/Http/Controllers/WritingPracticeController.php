<?php

namespace App\Http\Controllers;

use App\Models\WritingSubmission;
use App\Models\WritingTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WritingPracticeController extends Controller
{
    public function index(Request $request)
    {
        $part = $request->query('part');

        $query = WritingTask::where('is_published', true)->latest();

        if ($part && in_array($part, ['part_1', 'part_2', 'part_3'])) {
            $query->where('part', $part);
        }

        $tasks = $query->get();

        $userSubmissions = [];
        if (Auth::check()) {
            $userSubmissions = WritingSubmission::where('user_id', Auth::id())
                ->latest()
                ->get()
                ->keyBy('writing_task_id');
        }

        return view('writing_practice.index', compact('tasks', 'part', 'userSubmissions'));
    }

    public function practice($slug)
    {
        $task = WritingTask::where('slug', $slug)->firstOrFail();
        $previousSubmission = null;

        if (Auth::check()) {
            $previousSubmission = WritingSubmission::where('user_id', Auth::id())
                ->where('writing_task_id', $task->id)
                ->latest()
                ->first();
        }

        return view('writing_practice.practice', compact('task', 'previousSubmission'));
    }

    public function submit(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:5',
        ]);

        $task = WritingTask::findOrFail($id);
        $content = trim($request->input('content'));
        $wordCount = str_word_count($content);

        WritingSubmission::create([
            'user_id' => Auth::id(),
            'writing_task_id' => $task->id,
            'content' => $content,
            'word_count' => $wordCount,
        ]);

        return redirect()->route('writing_practice.practice', $task->slug)->with('success', 'Nộp bài viết thành công! Bạn có thể xem bài mẫu tham khảo bên dưới.');
    }
}