@extends('layouts.app')

@section('title', 'Luyện Viết TOEIC Writing - TOEIC VCATH')

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
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">✍️ Luyện Viết TOEIC Writing</h1>
    <p style="color: #64748b; font-size: 14px;">Thực hành các dạng bài viết Part 1 (Viết câu theo tranh), Part 2 (Email phản hồi), Part 3 (Bài luận ý kiến).</p>
</div>

<!-- Filter Part -->
<div style="display: flex; gap: 10px; margin-bottom: 26px; flex-wrap: wrap;">
    <a href="{{ route('writing_practice.index') }}" class="filter-btn {{ empty($part) ? 'active' : '' }}">Tất cả Parts</a>
    <a href="{{ route('writing_practice.index', ['part' => 'part_1']) }}" class="filter-btn {{ $part === 'part_1' ? 'active' : '' }}">Part 1 (Viết câu)</a>
    <a href="{{ route('writing_practice.index', ['part' => 'part_2']) }}" class="filter-btn {{ $part === 'part_2' ? 'active' : '' }}">Part 2 (Trả lời Email)</a>
    <a href="{{ route('writing_practice.index', ['part' => 'part_3']) }}" class="filter-btn {{ $part === 'part_3' ? 'active' : '' }}">Part 3 (Bài luận)</a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
    @forelse($tasks as $task)
        @php
            $sub = $userSubmissions[$task->id] ?? null;
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #ecfdf5; color: #059669; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        {{ str_replace('_', ' ', $task->part) }}
                    </span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">⏱️ {{ $task->time_limit_minutes }} phút</span>
                </div>
                <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 8px; line-height: 1.4;">{{ $task->title }}</h3>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 16px; line-height: 1.5;">
                    {{ Str::limit(strip_tags($task->prompt), 100) }}
                </p>

                @if($sub)
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 8px 12px; font-size: 12.5px; color: #166534; font-weight: 700; margin-bottom: 16px;">
                        ✅ Đã hoàn thành ({{ $sub->word_count }} từ)
                    </div>
                @endif
            </div>

            <a href="{{ route('writing_practice.practice', $task->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #0284c7; color: #ffffff; padding: 10px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 700; text-decoration: none;">
                Luyện viết ngay &rarr;
            </a>
        </div>
    @empty
        <p style="color: #64748b;">Chưa có bài luyện viết nào trong danh mục này.</p>
    @endforelse
</div>
@endsection