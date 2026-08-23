<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Danh sách câu hỏi có lọc theo bài học
    public function index(Request $request)
    {
        $lessonId = $request->query('lesson_id');

        $lessons = Lesson::orderBy('title')->get();

        $query = Question::with('lesson.course')->latest();

        if ($lessonId) {
            $query->where('lesson_id', $lessonId);
        }

        $questions = $query->paginate(10);

        return view('admin.questions.index', compact('questions', 'lessons', 'lessonId'));
    }

    // Giao diện thêm câu hỏi mới
    public function create()
    {
        $lessons = Lesson::with('course')->get();
        return view('admin.questions.create', compact('lessons'));
    }

    // Lưu câu hỏi mới
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string',
        ]);

        Question::create($request->all());

        return redirect()->route('admin.questions.index', ['lesson_id' => $request->lesson_id])
            ->with('success', 'Đã thêm câu hỏi trắc nghiệm mới thành công!');
    }

    // Xóa câu hỏi
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $lessonId = $question->lesson_id;
        $question->delete();

        return redirect()->route('admin.questions.index', ['lesson_id' => $lessonId])
            ->with('success', 'Đã xóa câu hỏi trắc nghiệm thành công!');
    }
}