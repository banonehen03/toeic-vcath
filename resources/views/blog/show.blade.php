@extends('layouts.app')

@section('title', $post->title . ' - TOEIC VCATH')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    <a href="{{ route('blog.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách bài viết
    </a>

    <article style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); margin-bottom: 30px;">
        <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 8px; text-transform: uppercase;">
            {{ $post->category }}
        </span>

        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 14px 0 10px; line-height: 1.35;">{{ $post->title }}</h1>
        <div style="font-size: 13px; color: #64748b; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            Đăng bởi: <b>{{ $post->author->name ?? 'Admin' }}</b> &bull; {{ $post->created_at->format('d/m/Y') }} &bull; {{ $post->views_count }} lượt xem
        </div>

        @if($post->thumbnail)
            <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" style="width: 100%; max-height: 380px; object-fit: cover; border-radius: 12px; margin-bottom: 24px;">
        @endif

        <div style="font-size: 15px; line-height: 1.8; color: #1e293b;">
            {!! $post->content !!}
        </div>
    </article>
</div>
@endsection