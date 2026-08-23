@extends('layouts.app')

@section('title', 'Bài Viết & Mẹo Thi TOEIC - TOEIC VCATH')

@push('styles')
<style>
    .blog-filter-btn {
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        background: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .blog-filter-btn:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    .blog-filter-btn.active {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">📝 Mẹo Thi & Lộ Trình TOEIC</h1>
        <p style="color: #64748b; font-size: 14px;">Tổng hợp bài viết chia sẻ kinh nghiệm luyện thi, ngữ pháp trọng tâm và chiến thuật làm bài điểm cao.</p>
    </div>

    <!-- Bộ lọc chủ đề -->
    <div style="display: flex; gap: 10px; margin-bottom: 26px; flex-wrap: wrap;">
        <a href="{{ route('blog.index') }}" class="blog-filter-btn {{ empty($category) ? 'active' : '' }}">
            Tất cả
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('blog.index', ['category' => $cat]) }}" class="blog-filter-btn {{ $category === $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Danh sách Grid bài viết -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 22px;">
        @forelse($posts as $p)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div>
                    @if($p->thumbnail)
                        <img src="{{ $p->thumbnail }}" alt="{{ $p->title }}" style="width: 100%; height: 160px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 160px; background: linear-gradient(135deg, #0284c7, #38bdf8); display: flex; align-items: center; justify-content: center; font-size: 32px;">📖</div>
                    @endif
                    <div style="padding: 18px;">
                        <span style="background: #e0f2fe; color: #0284c7; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">{{ $p->category }}</span>
                        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 10px 0 6px; line-height: 1.4;">{{ $p->title }}</h3>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 12px;">{{ Str::limit($p->summary, 90) }}</p>
                    </div>
                </div>
                <div style="padding: 0 18px 18px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; color: #94a3b8;">👁️ {{ $p->views_count }} lượt xem</span>
                    <a href="{{ route('blog.show', $p->slug) }}" style="color: #0284c7; font-weight: 700; font-size: 13px; text-decoration: none;">Đọc tiếp &rarr;</a>
                </div>
            </div>
        @empty
            <p style="color: #94a3b8;">Chưa có bài viết nào.</p>
        @endforelse
    </div>

    <div style="margin-top: 24px;">{{ $posts->links() }}</div>
</div>
@endsection