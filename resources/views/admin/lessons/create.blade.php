@extends('layouts.app')

@section('title', 'Thêm Bài Giảng - ' . $course->title)

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <a href="{{ route('admin.courses.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách khóa học
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 12px;">
            Khóa: {{ $course->title }}
        </span>
        <h1 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 10px 0 20px;">Thêm Bài Giảng Mới</h1>

        <form action="{{ route('admin.lessons.store', $course->id) }}" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Tiêu đề bài học (*)</label>
                <input type="text" name="title" required placeholder="ví dụ: Bài 01: Kỹ thuật phân tích cấu trúc câu Part 5" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Link Video Bài Giảng (YouTube / Vimeo / MP4)</label>
                    <input type="text" name="video_url" placeholder="https://www.youtube.com/embed/..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Thời lượng (phút)</label>
                    <input type="number" name="duration" min="1" value="15" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Nội dung bài đọc / Tài liệu kèm theo</label>
                <textarea name="content" rows="5" placeholder="Ghi chú kiến thức trọng tâm, tài liệu đính kèm..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none;"></textarea>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_preview" value="1"> Cho phép học viên học thử miễn phí (Preview)
                </label>
            </div>

            <button type="submit" style="width: 100%; background: #0284c7; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer;">
                Lưu Bài Giảng
            </button>
        </form>
    </div>
</div>
@endsection