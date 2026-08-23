@extends('layouts.app')

@section('title', 'Luyện Nghe TOEIC Listening - TOEIC VCATH')

@push('styles')
<style>
    .filter-btn {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        background: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .filter-btn:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .filter-btn.active {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 24px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">🎧 Luyện Nghe TOEIC Listening</h1>
    <p style="color: #64748b; font-size: 14px;">Luyện nghe phân tách theo từng Part 1, Part 2, Part 3, Part 4 có Audio và Transcript chi tiết.</p>
</div>

<!-- Bộ lọc theo Part -->
<div style="display: flex; gap: 10px; margin-bottom: 26px; flex-wrap: wrap;">
    <a href="{{ route('listening.index') }}" class="filter-btn {{ empty($part) ? 'active' : '' }}">
        Tất cả Parts
    </a>
    <a href="{{ route('listening.index', ['part' => 'part_1']) }}" class="filter-btn {{ $part === 'part_1' ? 'active' : '' }}">
        Part 1 (Hình ảnh)
    </a>
    <a href="{{ route('listening.index', ['part' => 'part_2']) }}" class="filter-btn {{ $part === 'part_2' ? 'active' : '' }}">
        Part 2 (Hỏi & Đáp)
    </a>
    <a href="{{ route('listening.index', ['part' => 'part_3']) }}" class="filter-btn {{ $part === 'part_3' ? 'active' : '' }}">
        Part 3 (Hội thoại)
    </a>
    <a href="{{ route('listening.index', ['part' => 'part_4']) }}" class="filter-btn {{ $part === 'part_4' ? 'active' : '' }}">
        Part 4 (Bài nói ngắn)
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
    @forelse($lessons as $lesson)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #f0fdf4; color: #16a34a; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        {{ str_replace('_', ' ', $lesson->part) }}
                    </span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">{{ $lesson->questions_count }} Câu hỏi</span>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.4;">{{ $lesson->title }}</h3>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.5;">{{ $lesson->description }}</p>
            </div>
            
            <a href="{{ route('listening.practice', $lesson->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #0284c7; color: #ffffff; padding: 10px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 700; text-decoration: none;">
                Luyện nghe ngay &rarr;
            </a>
        </div>
    @empty
        <p style="color: #64748b;">Chưa có bài luyện nghe nào trong danh mục này.</p>
    @endforelse
</div>
@endsection