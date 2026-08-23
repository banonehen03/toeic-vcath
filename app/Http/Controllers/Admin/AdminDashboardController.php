<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Feedback;
use App\Models\MockExamResult;
use App\Models\MockExamResultSW; // Đúng tên Model trong dự án của bạn
use App\Models\Post;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê số liệu hệ thống
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalCourses = Course::count();
        $totalQuestions = Question::count();
        $totalPosts = Post::count();
        $pendingFeedbacks = Feedback::where('status', 'pending')->count();
        
        $totalMockLR = MockExamResult::count();
        $pendingSw = MockExamResultSW::where('status', 'pending')->count();

        // 2. Danh sách bài thi Speaking & Writing cần chấm
        $pendingSwList = MockExamResultSW::with(['user', 'exam'])
            ->where('status', 'pending')
            ->latest()
            ->take(8)
            ->get();

        // 3. Phản hồi góp ý mới nhất
        $recentFeedbacks = Feedback::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCourses',
            'totalQuestions',
            'totalPosts',
            'pendingFeedbacks',
            'totalMockLR',
            'pendingSw',
            'pendingSwList',
            'recentFeedbacks'
        ));
    }
}