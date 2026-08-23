@extends('layouts.app')

@section('title', 'Tạo Khóa Học Mới - Admin')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <a href="{{ route('admin.courses.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách khóa học
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <h1 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Tạo Khóa Học Mới</h1>

        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Tên khóa học (*)</label>
                <input type="text" name="title" required placeholder="ví dụ: Khóa Học TOEIC Chinh Phục 650+ Cơ Bản" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Cấp độ mục tiêu</label>
                    <select name="level" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: white;">
                        <option value="TOEIC 450+">TOEIC 450+</option>
                        <option value="TOEIC 650+">TOEIC 650+</option>
                        <option value="TOEIC 800+">TOEIC 800+</option>
                        <option value="All Levels">Mọi cấp độ</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Học phí (VNĐ, để 0 nếu Free)</label>
                    <input type="number" name="price" min="0" value="0" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Ảnh đại diện (Thumbnail URL)</label>
                <input type="url" name="thumbnail" placeholder="https://images.unsplash.com/..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Mô tả nội dung khóa học</label>
                <textarea name="description" rows="4" placeholder="Tổng quan lộ trình, mục tiêu đạt được sau khóa học..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none;"></textarea>
            </div>

            <button type="submit" style="width: 100%; background: #0284c7; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer;">
                Lưu & Xuất Bản Khóa Học
            </button>
        </form>
    </div>
</div>
@endsection