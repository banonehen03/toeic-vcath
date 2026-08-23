@extends('layouts.app')

@section('title', 'Quản Lý Khóa Học - Admin TOEIC VCATH')

@section('content')
<div style="max-width: 1040px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">🎓 Quản Lý Khóa Học & Bài Giảng</h1>
            <p style="color: #64748b; font-size: 14px;">Quản lý nội dung chương trình học, bài giảng video và học viên đăng ký.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dashboard') }}" style="background: #f1f5f9; color: #475569; padding: 9px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">&larr; Dashboard</a>
            <a href="{{ route('admin.courses.create') }}" style="background: #0284c7; color: white; padding: 9px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">+ Thêm khóa học mới</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left; color: #64748b;">
                        <th style="padding: 10px 12px;">Khóa học</th>
                        <th style="padding: 10px 12px;">Cấp độ</th>
                        <th style="padding: 10px 12px;">Số bài học</th>
                        <th style="padding: 10px 12px;">Học viên</th>
                        <th style="padding: 10px 12px;">Học phí</th>
                        <th style="padding: 10px 12px; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $c)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 14px 12px; font-weight: 700; color: #1e293b;">
                                {{ $c->title }}
                            </td>
                            <td style="padding: 14px 12px;">
                                <span style="background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    {{ $c->level ?? 'Mọi cấp độ' }}
                                </span>
                            </td>
                            <td style="padding: 14px 12px; color: #0284c7; font-weight: 700;">{{ $c->lessons_count }} bài</td>
                            <td style="padding: 14px 12px; color: #059669; font-weight: 700;">{{ $c->enrollments_count }} học viên</td>
                            <td style="padding: 14px 12px; font-weight: 700; color: #db2777;">
                                {{ $c->price > 0 ? number_format($c->price) . ' VNĐ' : 'Miễn phí' }}
                            </td>
                            <td style="padding: 14px 12px; text-align: right;">
                                <a href="{{ route('admin.lessons.create', $c->id) }}" style="background: #e0f2fe; color: #0284c7; padding: 6px 12px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 12.5px;">
                                    + Thêm bài giảng
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 24px; text-align: center; color: #94a3b8;">Chưa có khóa học nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection