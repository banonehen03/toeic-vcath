@extends('layouts.app')

@section('title', 'Bảng Điều Khiển Quản Trị - TOEIC VCATH Admin')

@push('styles')
<style>
    .admin-nav-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .admin-nav-card:hover {
        transform: translateY(-3px);
        border-color: #0284c7;
        box-shadow: 0 10px 20px rgba(2, 132, 199, 0.08);
    }
    .admin-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    .stat-pill {
        font-size: 11.5px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1060px; margin: 0 auto;">

    <!-- Header Quản Trị -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 26px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">🛠️ Bảng Điều Khiển Quản Trị Viên</h1>
            <p style="color: #64748b; font-size: 14px;">Giám sát toàn bộ hoạt động học tập, chấm điểm bài thi và quản lý dữ liệu hệ thống.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('courses.index') }}" target="_blank" style="background: #f1f5f9; color: #475569; padding: 9px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">
                🌐 Xem trang Client
            </a>
        </div>
    </div>

    <!-- KHU VỰC 1: LỐI TẮT QUẢN LÝ (MANAGEMENT MODULES) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 28px;">
        <!-- Khóa học -->
        <a href="{{ route('admin.courses.index') }}" class="admin-nav-card">
            <div class="admin-icon-box" style="background: #e0f2fe; color: #0284c7;">🎓</div>
            <div>
                <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Quản Lý Khóa Học</div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">{{ $totalCourses }} khóa học &bull; Bài giảng</div>
            </div>
        </a>

        <!-- Ngân hàng câu hỏi -->
        <a href="{{ route('admin.questions.index') }}" class="admin-nav-card">
            <div class="admin-icon-box" style="background: #fef3c7; color: #d97706;">❓</div>
            <div>
                <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Ngân Hàng Câu Hỏi</div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">{{ $totalQuestions }} câu trắc nghiệm</div>
            </div>
        </a>

        <!-- Bài viết / Blog -->
        <a href="{{ route('admin.blog.index') }}" class="admin-nav-card">
            <div class="admin-icon-box" style="background: #ecfdf5; color: #059669;">📝</div>
            <div>
                <div style="font-size: 15px; font-weight: 800; color: #0f172a;">Quản Lý Bài Viết</div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">{{ $totalPosts }} bài &bull; Mẹo thi TOEIC</div>
            </div>
        </a>

        <!-- Góp ý / Báo lỗi -->
        <a href="{{ route('admin.feedback.index') }}" class="admin-nav-card">
            <div class="admin-icon-box" style="background: #fee2e2; color: #b91c1c;">📬</div>
            <div>
                <div style="font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                    Góp Ý & Báo Lỗi
                    @if($pendingFeedbacks > 0)
                        <span class="stat-pill" style="background: #fee2e2; color: #b91c1c;">{{ $pendingFeedbacks }} mới</span>
                    @endif
                </div>
                <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">Tiếp nhận phản hồi</div>
            </div>
        </a>
    </div>

    <!-- KHU VỰC 2: 4 THẺ CHỈ SỐ KPI -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tổng học viên</div>
            <div style="font-size: 26px; font-weight: 800; color: #0284c7; margin: 4px 0;">{{ $totalUsers }}</div>
            <div style="font-size: 12px; color: #94a3b8;">Tài khoản đã đăng ký</div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Lượt làm bài Mock L&R</div>
            <div style="font-size: 26px; font-weight: 800; color: #059669; margin: 4px 0;">{{ $totalMockLR }}</div>
            <div style="font-size: 12px; color: #94a3b8;">Đã chấm điểm tự động</div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Bài thi S&W chờ chấm</div>
            <div style="font-size: 26px; font-weight: 800; color: #d97706; margin: 4px 0;">{{ $pendingSw }}</div>
            <div style="font-size: 12px; color: #94a3b8;">Cần giáo viên đánh giá</div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px;">
            <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase;">Phản hồi chờ xử lý</div>
            <div style="font-size: 26px; font-weight: 800; color: #dc2626; margin: 4px 0;">{{ $pendingFeedbacks }}</div>
            <div style="font-size: 12px; color: #94a3b8;">Hòm thư góp ý/báo lỗi</div>
        </div>
    </div>

    <!-- KHU VỰC 3: BÀI THI SPEAKING & WRITING CẦN CHẤM ĐIỂM -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <div>
                <h2 style="font-size: 17px; font-weight: 800; color: #0f172a;">🎙️ Bài Thi Speaking & Writing Cần Chấm Điểm</h2>
                <p style="color: #64748b; font-size: 13px; margin-top: 2px;">Nghe file ghi âm phát âm, đọc bài luận viết và cho điểm học viên.</p>
            </div>
            <span class="stat-pill" style="background: #fef3c7; color: #92400e;">{{ $pendingSw }} bài đang đợi</span>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left; color: #64748b;">
                        <th style="padding: 10px 12px;">Học viên</th>
                        <th style="padding: 10px 12px;">Bộ đề</th>
                        <th style="padding: 10px 12px;">Thời gian nộp</th>
                        <th style="padding: 10px 12px;">Trạng thái</th>
                        <th style="padding: 10px 12px; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingSwList as $sw)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 14px 12px; font-weight: 700; color: #1e293b;">
                                {{ $sw->user->name ?? 'Học viên ẩn danh' }}
                                <div style="font-size: 12px; color: #64748b; font-weight: 400;">{{ $sw->user->email ?? '' }}</div>
                            </td>
                            <td style="padding: 14px 12px; color: #0284c7; font-weight: 600;">
                                {{ $sw->exam->title ?? 'Bộ đề S&W Chuẩn' }}
                            </td>
                            <td style="padding: 14px 12px; color: #64748b;">
                                {{ $sw->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="padding: 14px 12px;">
                                <span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: 700;">
                                    Chờ chấm điểm
                                </span>
                            </td>
                            <td style="padding: 14px 12px; text-align: right;">
                                <a href="{{ route('admin.grade_sw', $sw->id) }}" style="background: #0284c7; color: white; padding: 7px 14px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 12.5px;">
                                    Chấm điểm ngay &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 28px; text-align: center; color: #94a3b8;">
                                🎉 Hiện không có bài thi Speaking & Writing nào đang chờ chấm!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection