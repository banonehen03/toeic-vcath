@extends('layouts.app')

@section('title', 'Thi Thử TOEIC Speaking & Writing - TOEIC VCATH')

@push('styles')
<style>
    .status-graded {
        color: #059669;
        font-weight: 800;
    }
    .status-submitted {
        color: #d97706;
        font-weight: 800;
    }
</style>
@endpush

@section('content')
<div style="margin-bottom: 28px;">
    <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">🎙️ Phòng Thi Thử TOEIC Speaking & Writing</h1>
    <p style="color: #64748b; font-size: 14px;">Môi trường thi thử 2 kỹ năng Nói & Viết theo chuẩn format ETS với công cụ ghi âm trực tiếp và đếm số lượng từ thời gian thực.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">
    @forelse($exams as $exam)
        @php
            $res = $userResults[$exam->id] ?? null;
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="background: #fdf2f8; color: #db2777; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">⏱️ {{ $exam->duration_minutes }} Phút</span>
                    <span style="color: #94a3b8; font-size: 12px; font-weight: 600;">{{ $exam->questions_count }} Câu hỏi</span>
                </div>
                <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 8px; line-height: 1.4;">{{ $exam->title }}</h3>
                <p style="font-size: 13.5px; color: #64748b; margin-bottom: 18px; line-height: 1.5;">{{ $exam->description }}</p>

                @if($res)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px;">
                        <div style="color: #475569; font-weight: 600;">
                            Trạng thái bài nộp: 
                            <span class="{{ $res->status === 'graded' ? 'status-graded' : 'status-submitted' }}">
                                {{ $res->status === 'graded' ? 'Đã chấm điểm' : 'Đã nộp bài (Chờ chấm)' }}
                            </span>
                        </div>
                        @if($res->status === 'graded')
                            <div style="color: #0284c7; font-weight: 800; margin-top: 4px;">
                                Điểm: Speaking {{ $res->speaking_score }}/200 | Writing {{ $res->writing_score }}/200
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @auth
                <a href="{{ route('mock_test_sw.take', $exam->slug) }}" style="display: inline-flex; align-items: center; justify-content: center; background: #0284c7; color: #ffffff; padding: 11px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none;">
                    Bắt đầu thi Speaking & Writing &rarr;
                </a>
            @else
                <button type="button" onclick="openAuthModal('Phòng Thi Thử S&W')" style="background: #0284c7; color: #ffffff; border: none; padding: 11px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer;">
                    Đăng nhập để vào thi
                </button>
            @endauth
        </div>
    @empty
        <p style="color: #64748b;">Hiện tại chưa có đề thi Nói & Viết nào.</p>
    @endforelse
</div>
@endsection