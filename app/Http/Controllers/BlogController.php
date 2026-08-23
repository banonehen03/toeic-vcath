<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $query = Post::with('author')
            ->where('is_published', true)
            ->latest();

        if ($category) {
            $query->where('category', $category);
        }

        $posts = $query->paginate(6);
        $categories = Post::select('category')->distinct()->pluck('category');

        return view('blog.index', compact('posts', 'categories', 'category'));
    }

    public function show($slug)
    {
        $post = Post::with('author')->where('slug', $slug)->firstOrFail();
        $post->increment('views_count');

        $relatedPosts = Post::where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}