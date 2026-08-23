<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved',
            'admin_note' => 'nullable|string',
        ]);

        $item = Feedback::findOrFail($id);
        $item->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.feedback.index')->with('success', 'Đã cập nhật trạng thái phản hồi!');
    }

    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Đã xóa phản hồi thành công!');
    }
}