@extends('layouts.app')

@section('title', 'Luyện Tập Ngữ Pháp TOEIC - TOEIC VCATH')

@section('content')
<div style="margin-bottom: 28px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">📖 Luyện Tập Trắc Nghiệm Ngữ Pháp TOEIC</h1>
    <p style="color: #64748b; font-size: 14px;">Thực hành trực tiếp các bài tập ngữ pháp thực chiến Part 5 có chấm điểm và giải thích chi tiết.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
    @forelse($lessons as $lesson)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #ecfdf5; color: #059669; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">{{ $lesson->questions_count }} Câu hỏi</span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">Chủ đề {{ $lesson->order_index }}</span>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.4;">{{ $lesson->title }}</h3>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 18px;">{{ $lesson->summary }}</p>
            </div>
            
            <a href="{{ route('grammar_practice.practice', $lesson->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #059669; color: #ffffff; padding: 10px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 700; text-decoration: none;">
                Bắt đầu làm bài &rarr;
            </a>
        </div>
    @empty
        <p style="color: #64748b;">Chưa có bộ đề trắc nghiệm nào.</p>
    @endforelse
</div>
@endsection