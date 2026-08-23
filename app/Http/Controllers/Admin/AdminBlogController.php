<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('author')->latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|url',
        ]);

        Post::create([
            'user_id' => Auth::id() ?? 1,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category' => $request->category,
            'summary' => $request->summary,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'is_published' => true,
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Đã xuất bản bài viết mới thành công!');
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Đã xóa bài viết thành công!');
    }
}