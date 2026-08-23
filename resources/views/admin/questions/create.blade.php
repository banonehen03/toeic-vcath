@extends('layouts.app')

@section('title', 'Thêm Câu Hỏi Trắc Nghiệm - Admin')

@section('content')
<div style="max-width: 720px; margin: 0 auto;">
    <a href="{{ route('admin.questions.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách câu hỏi
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <h1 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Thêm Câu Hỏi Trắc Nghiệm Mới</h1>

        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Chọn bài học trực thuộc (*)</label>
                <select name="lesson_id" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: white;">
                    <option value="">-- Chọn bài học --</option>
                    @foreach($lessons as $l)
                        <option value="{{ $l->id }}">{{ $l->course->title ?? '' }} &rarr; {{ $l->title }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Nội dung câu hỏi (*)</label>
                <textarea name="question_text" required rows="3" placeholder="Nhập câu hỏi hoặc câu có chỗ trống cần điền..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px;">Đáp án A (*)</label>
                    <input type="text" name="option_a" required placeholder="Lựa chọn A" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px;">Đáp án B (*)</label>
                    <input type="text" name="option_b" required placeholder="Lựa chọn B" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px;">Đáp án C (*)</label>
                    <input type="text" name="option_c" required placeholder="Lựa chọn C" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 4px;">Đáp án D (*)</label>
                    <input type="text" name="option_d" required placeholder="Lựa chọn D" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Đáp án chính xác (*)</label>
                <select name="correct_option" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: white; font-weight: 700; color: #166534;">
                    <option value="A">Đáp án A</option>
                    <option value="B">Đáp án B</option>
                    <option value="C">Đáp án C</option>
                    <option value="D">Đáp án D</option>
                </select>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Giải thích chi tiết đáp án</label>
                <textarea name="explanation" rows="3" placeholder="Giải thích lý do chọn đáp án, cấu trúc ngữ pháp liên quan..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none;"></textarea>
            </div>

            <button type="submit" style="width: 100%; background: #0284c7; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer;">
                Lưu Câu Hỏi
            </button>
        </form>
    </div>
</div>
@endsection