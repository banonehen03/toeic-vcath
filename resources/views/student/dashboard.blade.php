@extends('layouts.app')

@section('title', 'Tổng quan Học tập - Học viên')

@push('styles')
<style>
    .dashboard-container { max-width: 1000px; margin: 0 auto; }
    .top-nav-dash { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .btn-new-quiz { background: var(--primary); color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: background 0.2s; }
    .btn-new-quiz:hover { background: #047857; }

    /* Stats Grid */
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 35px; }
    .stat-card { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
    .stat-card h4 { font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; font-weight: 700; }
    .stat-card .value { font-size: 32px; font-weight: 800; color: var(--primary); }

    /* Table Section */
    .section-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
    .table-card { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); margin-bottom: 30px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
    th { color: var(--text-muted); font-weight: 600; font-size: 13px; text-transform: uppercase; }
    
    .badge { padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 700; }
    .badge-green { background: #d1fae5; color: #065f46; }
    .badge-orange { background: #ffedd5; color: #9a3412; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="top-nav-dash">
        <div>
            <a href="{{ route('courses.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 600;">&larr; Về trang chủ</a>
            <h2 style="margin-top: 6px; font-size: 24px; font-weight: 800;">Hồ Sơ Học Tập Của Bạn</h2>
        </div>
        <div>
            <a href="{{ route('quiz.index') }}" class="btn-new-quiz">+ Làm bài thi mới</a>
        </div>
    </div>

    <!-- Thẻ thống kê nhanh -->
    <div class="stats-grid">
        <div class="stat-card">
            <h4>Từ Vựng Đã Lưu</h4>
            <div class="value">{{ $savedVocabCount }} từ</div>
        </div>
        <div class="stat-card">
            <h4>Điểm Thi Trung Bình</h4>
            <div class="value" style="color: #0284c7;">{{ round($averageScore) }}%</div>
        </div>
        <div class="stat-card">
            <h4>Số Lần Làm Đề Thi</h4>
            <div class="value" style="color: #7c3aed;">{{ $quizResults->count() }} lần</div>
        </div>
    </div>

    <!-- Bảng Lịch sử làm bài trắc nghiệm -->
    <h3 class="section-title">Lịch Sử Làm Đề Thi Gần Nhất</h3>
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Điểm số</th>
                    <th>Tỷ lệ chính xác</th>
                    <th>Đánh giá</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizResults as $res)
                    <tr>
                        <td>{{ $res->created_at->format('H:i - d/m/Y') }}</td>
                        <td><b>{{ $res->score }} / {{ $res->total_questions }}</b></td>
                        <td><b>{{ $res->percentage }}%</b></td>
                        <td>
                            @if($res->percentage >= 70)
                                <span class="badge badge-green">Xuất sắc</span>
                            @else
                                <span class="badge badge-orange">Cần ôn tập thêm</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94a3b8; padding: 24px;">Bạn chưa thực hiện bài thi trắc nghiệm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection