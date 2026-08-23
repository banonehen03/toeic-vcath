@extends('layouts.app')

@section('title', 'Thi Thử TOEIC Full L&R - TOEIC VCATH')

@section('content')
<div style="margin-bottom: 28px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">🏆 Phòng Thi Thử TOEIC Full L&R</h1>
    <p style="color: #64748b; font-size: 14px;">Trải nghiệm cấu trúc đề thi TOEIC chuẩn format quốc tế với giao diện thi thực chiến và chấm điểm tức thì.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">
    @forelse($exams as $exam)
        @php
            $res = $userResults[$exam->id] ?? null;
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #fef3c7; color: #d97706; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">⏱️ {{ $exam->duration_minutes }} Phút</span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">{{ $exam->questions_count }} Câu hỏi</span>
                </div>
                <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 8px; line-height: 1.4;">{{ $exam->title }}</h3>
                <p style="font-size: 13.5px; color: #64748b; margin-bottom: 18px; line-height: 1.5;">{{ $exam->description }}</p>

                @if($res)
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 8px 12px; font-size: 13px; color: #166534; font-weight: 700; margin-bottom: 16px;">
                        Điểm lần thi gần nhất: <span style="font-size: 15px; color: #059669;">{{ $res->total_score }}/990</span> (L: {{ $res->listening_score }} | R: {{ $res->reading_score }})
                    </div>
                @endif
            </div>

            @auth
                <a href="{{ route('mock_test.take', $exam->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #0284c7; color: #ffffff; padding: 11px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none;">
                    Vào phòng thi &rarr;
                </a>
            @else
                <button type="button" onclick="openAuthModal('Phòng Thi Thử TOEIC')" style="background: #0284c7; color: #ffffff; border: none; padding: 11px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer;">
                    Đăng nhập để vào thi
                </button>
            @endauth
        </div>
    @empty
        <p style="color: #64748b;">Hiện tại chưa có đề thi nào được xuất bản.</p>
    @endforelse
</div>
@endsection