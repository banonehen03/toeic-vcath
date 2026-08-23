@extends('layouts.app')

@section('title', 'Khóa học Ngữ pháp TOEIC - TOEIC VCATH')

@section('content')
<div style="margin-bottom: 28px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">🎓 Khóa học Ngữ Pháp Trọng Điểm TOEIC</h1>
    <p style="color: #64748b; font-size: 14px;">Hệ thống toàn bộ chủ điểm ngữ pháp hay xuất hiện nhất trong bài thi TOEIC.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
    @forelse($lessons as $lesson)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">{{ $lesson->level }}</span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">Bài {{ $lesson->order_index }}</span>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.4;">{{ $lesson->title }}</h3>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">{{ $lesson->summary }}</p>
            </div>
            <a href="{{ route('grammar.show', $lesson->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #0284c7; color: #ffffff; padding: 9px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 700; text-decoration: none;">
                Học bài này &rarr;
            </a>
        </div>
    @empty
        <p style="color: #64748b;">Chưa có bài học nào được đăng tải.</p>
    @endforelse
</div>
@endsection