<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    // Trang tổng quan: Sổ tay cá nhân + Danh sách các chủ đề từ vựng
    public function index()
    {
        $userId = Auth::id() ?? 1;
        $vocabularies = Vocabulary::where('user_id', $userId)
            ->orWhereNull('user_id')
            ->latest()
            ->get();

        $categories = VocabularyCategory::withCount('words')
            ->where('is_published', true)
            ->orderBy('order_index', 'asc')
            ->get();

        return view('vocabularies.index', compact('vocabularies', 'categories'));
    }

    // Trang chi tiết học Flashcard theo từng chủ đề
    public function show($slug)
    {
        $category = VocabularyCategory::where('slug', $slug)
            ->with('words')
            ->firstOrFail();

        return view('vocabularies.show', compact('category'));
    }

    // Lưu từ vựng vào sổ tay
    public function store(Request $request)
    {
        $userId = Auth::id() ?? 1;

        $word = trim($request->input('word', ''));
        if (empty($word)) {
            return response()->json(['status' => 'error', 'message' => 'Từ không hợp lệ'], 400);
        }

        Vocabulary::updateOrCreate(
            [
                'user_id' => $userId,
                'word' => $word,
            ],
            [
                'ipa' => $request->input('ipa'),
                'meaning' => $request->input('meaning', ''),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Đã lưu vào sổ từ vựng thành công!'
        ]);
    }

    // Xóa từ khỏi sổ tay
    public function destroy($id)
    {
        $userId = Auth::id() ?? 1;
        Vocabulary::where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)->orWhereNull('user_id');
            })
            ->delete();

        return back()->with('success', 'Đã xóa từ khỏi danh sách!');
    }
}