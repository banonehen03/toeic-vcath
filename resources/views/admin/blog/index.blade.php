@extends('layouts.app')

@section('title', 'Quản Lý Bài Viết - Admin')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">📝 Quản Lý Bài Viết & Blog</h1>
            <p style="color: #64748b; font-size: 14px;">Tạo và quản lý các bài chia sẻ kinh nghiệm, mẹo thi TOEIC.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dashboard') }}" style="background: #f1f5f9; color: #475569; padding: 9px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">&larr; Dashboard</a>
            <a href="{{ route('admin.blog.create') }}" style="background: #0284c7; color: white; padding: 9px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">+ Viết bài mới</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
            <thead>
                <tr style="border-bottom: 1px solid #e2e8f0; text-align: left; color: #64748b;">
                    <th style="padding: 10px;">Tiêu đề bài viết</th>
                    <th style="padding: 10px;">Chủ đề</th>
                    <th style="padding: 10px;">Lượt xem</th>
                    <th style="padding: 10px; text-align: right;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $p)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px 10px; font-weight: 700; color: #1e293b;">{{ $p->title }}</td>
                        <td style="padding: 12px 10px;"><span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-size: 12px;">{{ $p->category }}</span></td>
                        <td style="padding: 12px 10px; color: #64748b;">{{ $p->views_count }}</td>
                        <td style="padding: 12px 10px; text-align: right;">
                            <form action="{{ route('admin.blog.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài này?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #b91c1c; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer;">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">Chưa có bài viết nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection