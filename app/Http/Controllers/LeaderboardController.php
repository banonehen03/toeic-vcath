<?php

namespace App\Http\Controllers;

use App\Models\ArenaMatch;
use App\Models\MockExamResult;
use App\Models\UserWordProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    // Bảng xếp hạng chung (Leaderboard)
    public function index()
    {
        // 1. Top 10 học viên điểm thi thử L&R cao nhất
        $topMockTests = MockExamResult::with('user')
            ->select('user_id', DB::raw('MAX(total_score) as best_score'), DB::raw('MAX(created_at) as last_attempt'))
            ->groupBy('user_id')
            ->orderByDesc('best_score')
            ->take(10)
            ->get();

        // 2. Top 10 cao thủ đấu trường Arena
        $topArena = ArenaMatch::with('user')
            ->select('user_id', DB::raw('MAX(score) as max_score'), DB::raw('MIN(time_spent_seconds) as min_time'))
            ->groupBy('user_id')
            ->orderByDesc('max_score')
            ->orderBy('min_time', 'asc')
            ->take(10)
            ->get();

        // 3. Top học chăm chỉ (thuộc nhiều từ vựng nhất)
        $topVocab = UserWordProgress::with('user')
            ->select('user_id', DB::raw('COUNT(*) as total_memorized'))
            ->where('is_memorized', true)
            ->groupBy('user_id')
            ->orderByDesc('total_memorized')
            ->take(10)
            ->get();

        return view('leaderboard.index', compact('topMockTests', 'topArena', 'topVocab'));
    }

    // Bảng vinh danh (Hall of Fame) - Điểm TOEIC 800+
    public function hallOfFame()
    {
        $highAchievers = MockExamResult::with('user')
            ->where('total_score', '>=', 800)
            ->select('user_id', DB::raw('MAX(total_score) as best_score'), DB::raw('MAX(created_at) as achieved_at'))
            ->groupBy('user_id')
            ->orderByDesc('best_score')
            ->get();

        return view('leaderboard.hall_of_fame', compact('highAchievers'));
    }
}