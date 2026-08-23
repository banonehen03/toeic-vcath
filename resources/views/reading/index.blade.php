@extends('layouts.app')

@section('title', 'Luyện Đọc TOEIC Reading - TOEIC VCATH')

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
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">📖 Luyện Đọc TOEIC Reading</h1>
    <p style="color: #64748b; font-size: 14px;">Luyện đọc chuyên sâu Part 5, Part 6 và Part 7 với văn bản mô phỏng đề thi thật và phân tích đáp án chi tiết.</p>
</div>

<!-- Bộ lọc theo Part -->
<div style="display: flex; gap: 10px; margin-bottom: 26px; flex-wrap: wrap;">
    <a href="{{ route('reading.index') }}" class="filter-btn {{ empty($part) ? 'active' : '' }}">Tất cả Parts</a>
    <a href="{{ route('reading.index', ['part' => 'part_5']) }}" class="filter-btn {{ $part === 'part_5' ? 'active' : '' }}">Part 5 (Hoàn thành câu)</a>
    <a href="{{ route('reading.index', ['part' => 'part_6']) }}" class="filter-btn {{ $part === 'part_6' ? 'active' : '' }}">Part 6 (Điền đoạn văn)</a>
    <a href="{{ route('reading.index', ['part' => 'part_7']) }}" class="filter-btn {{ $part === 'part_7' ? 'active' : '' }}">Part 7 (Đọc hiểu văn bản)</a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
    @forelse($lessons as $lesson)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #fdf4ff; color: #a855f7; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        {{ str_replace('_', ' ', $lesson->part) }}
                    </span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">{{ $lesson->questions_count }} Câu hỏi</span>
                </div>
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.4;">{{ $lesson->title }}</h3>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.5;">{{ $lesson->description }}</p>
            </div>
            
            <a href="{{ route('reading.practice', $lesson->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #0284c7; color: #ffffff; padding: 10px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 700; text-decoration: none;">
                Luyện đọc ngay &rarr;
            </a>
        </div>
    @empty
        <p style="color: #64748b;">Chưa có bài đọc nào trong danh mục này.</p>
    @endforelse
</div>
@endsection