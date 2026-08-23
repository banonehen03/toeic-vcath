@extends('layouts.app')

@section('title', 'Soạn Bài Viết Mới - Admin')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    <a href="{{ route('admin.blog.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách bài viết
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <h1 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Soạn Thảo Bài Viết Mới</h1>

        <form action="{{ route('admin.blog.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Tiêu đề bài viết (*)</label>
                <input type="text" name="title" required placeholder="Nhập tiêu đề bài viết..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Danh mục (*)</label>
                    <select name="category" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: white;">
                        <option value="Mẹo thi TOEIC">Mẹo thi TOEIC</option>
                        <option value="Lộ trình học">Lộ trình học</option>
                        <option value="Từ vựng - Ngữ pháp">Từ vựng - Ngữ pháp</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Ảnh Thumbnail (URL)</label>
                    <input type="url" name="thumbnail" placeholder="https://..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Tóm tắt ngắn</label>
                <textarea name="summary" rows="2" placeholder="1-2 câu tóm tắt nội dung chính..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Nội dung bài viết (Hỗ trợ HTML) (*)</label>
                <textarea name="content" rows="10" required placeholder="Nhập nội dung bài viết chi tiết..." style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; line-height: 1.6; outline: none;"></textarea>
            </div>

            <button type="submit" style="width: 100%; background: #0284c7; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer;">
                Xuất Bản Bài Viết
            </button>
        </form>
    </div>
</div>
@endsection