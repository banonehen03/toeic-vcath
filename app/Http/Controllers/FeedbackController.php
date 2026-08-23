<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('feedback.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'content' => 'required|string|min:10',
            'name' => Auth::check() ? 'nullable' : 'required|string|max:100',
            'email' => Auth::check() ? 'nullable' : 'required|email|max:150',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'name' => Auth::check() ? Auth::user()->name : $request->name,
            'email' => Auth::check() ? Auth::user()->email : $request->email,
            'type' => $request->type,
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'pending',
        ]);

        return redirect()->route('feedback.index')->with('success', 'Cảm ơn bạn! Ý kiến đóng góp của bạn đã được gửi tới ban quản trị.');
    }
}