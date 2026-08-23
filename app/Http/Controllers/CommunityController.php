<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\TopicComment;
use App\Models\TopicLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    // Danh sách bài thảo luận
    public function index(Request $request)
    {
        $tag = $request->query('tag');
        $query = Topic::with(['user', 'likes'])->latest();

        if ($tag) {
            $query->where('tag', $tag);
        }

        $topics = $query->paginate(10);
        $tags = ['Ngữ pháp', 'Luyện nghe', 'Đọc hiểu', 'Speaking & Writing', 'Thảo luận chung'];

        return view('community.index', compact('topics', 'tags', 'tag'));
    }

    // Chi tiết bài thảo luận + danh sách bình luận
    public function show($id)
    {
        $topic = Topic::with(['user', 'comments.user', 'likes'])->findOrFail($id);
        return view('community.show', compact('topic'));
    }

    // Đăng bài viết thảo luận mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'required|string',
            'content' => 'required|string|min:10',
        ]);

        Topic::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'tag' => $request->tag,
            'content' => $request->content,
        ]);

        return redirect()->route('community.index')->with('success', 'Đã đăng bài thảo luận thành công!');
    }

    // Gửi bình luận
    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:2',
        ]);

        $topic = Topic::findOrFail($id);
        TopicComment::create([
            'topic_id' => $topic->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        $topic->increment('comments_count');

        return redirect()->route('community.show', $id)->with('success', 'Đã gửi bình luận thành công!');
    }

    // Thả tim / Bỏ thả tim
    public function toggleLike($id)
    {
        $topic = Topic::findOrFail($id);
        $userId = Auth::id();

        $like = TopicLike::where('topic_id', $id)->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            $topic->decrement('likes_count');
            $liked = false;
        } else {
            TopicLike::create(['topic_id' => $id, 'user_id' => $userId]);
            $topic->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $topic->fresh()->likes_count,
        ]);
    }
}