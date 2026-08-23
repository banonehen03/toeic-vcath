@extends('layouts.app')

@section('title', 'Chào mừng đến với TOEIC VCATH')

@section('content')
<div style="text-align: center; padding: 60px 20px;">
    <h1 style="font-size: 40px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
        Chào mừng đến với <span style="color: var(--primary);">TOEIC VCATH</span>
    </h1>
    <p style="font-size: 16px; color: var(--text-muted); max-width: 600px; margin: 0 auto 30px; line-height: 1.6;">
        Nền tảng luyện thi TOEIC thông minh: tra từ điển ngữ cảnh trực tiếp trên bài đọc, flashcard ôn tập từ vựng và hệ thống thi thử trắc nghiệm có chấm điểm tự động.
    </p>

    <div style="display: flex; gap: 14px; justify-content: center;">
        <a href="{{ route('courses.index') }}" style="background: var(--primary); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 700; text-decoration: none;">
            Vào học ngay &rarr;
        </a>
        <a href="{{ route('quiz.index') }}" style="background: white; color: #0f172a; border: 1px solid #cbd5e1; padding: 12px 24px; border-radius: 10px; font-weight: 700; text-decoration: none;">
            Làm bài Mini Test
        </a>
    </div>
</div>
@endsection