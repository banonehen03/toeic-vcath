@extends('layouts.app')

@section('title', $lesson->title . ' - TOEIC VCATH')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    <a href="{{ route('grammar.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách bài học
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">{{ $lesson->level }}</span>
            <span style="color: #94a3b8; font-size: 13px; font-weight: 600;">Bài số {{ $lesson->order_index }}</span>
        </div>

        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 14px;">
            {{ $lesson->title }}
        </h1>

        <div style="line-height: 1.8; color: #334155; font-size: 15px;">
            {!! $lesson->content !!}
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
            @if($previousLesson)
                <a href="{{ route('grammar.show', $previousLesson->slug) }}" style="text-decoration: none; font-size: 13.5px; font-weight: 700; color: #0284c7;">
                    &larr; {{ $previousLesson->title }}
                </a>
            @else
                <div></div>
            @endif

            @if($nextLesson)
                <a href="{{ route('grammar.show', $nextLesson->slug) }}" style="text-decoration: none; font-size: 13.5px; font-weight: 700; color: #0284c7;">
                    {{ $nextLesson->title }} &rarr;
                </a>
            @endif
        </div>
    </div>
</div>
@endsection