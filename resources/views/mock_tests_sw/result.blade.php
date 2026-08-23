@extends('layouts.app')

@section('title', 'Kết Quả Bài Thi S&W - ' . $result->exam->title)

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.03); margin-bottom: 26px;">
        <span style="background: #ecfdf5; color: #059669; font-size: 13px; font-weight: 800; padding: 6px 14px; border-radius: 20px;">Đã Nộp Bài Thành Công</span>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 12px 0 16px;">{{ $result->exam->title }}</h1>
        <p style="color: #64748b; font-size: 14px; max-width: 600px; margin: 0 auto 20px;">Bài thi của bạn đã được ghi nhận vào hệ thống. Dưới đây là bài làm của bạn đối chiếu với các câu trả lời mẫu đạt chuẩn ETS.</p>

        <a href="{{ route('mock_test_sw.index') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #0284c7; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px;">
            &larr; Quay lại danh sách đề thi S&W
        </a>
    </div>

    <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Chi Tiết Bài Làm & Câu Trả Lời Mẫu</h2>

    @foreach($result->exam->questions as $q)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 800; font-size: 15px; color: #0284c7;">{{ $q->task_type }}</span>
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">{{ $q->skill }}</span>
            </div>

            <div style="background: #f8fafc; border-radius: 8px; padding: 14px; font-size: 14px; color: #1e293b; margin-bottom: 16px;">
                <b>Đề bài:</b> {!! nl2br(e($q->prompt)) !!}
            </div>

            @if($q->skill === 'writing')
                @php
                    $userText = $result->writing_answers[$q->id] ?? 'Chưa làm câu này';
                @endphp
                <div style="margin-bottom: 14px;">
                    <div style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Bài viết của bạn:</div>
                    <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; font-size: 14px; line-height: 1.6; color: #1e293b;">
                        {!! nl2br(e($userText)) !!}
                    </div>
                </div>
            @else
                <div style="margin-bottom: 14px; font-size: 13.5px; color: #059669; font-weight: 700;">
                    🎧 Đã ghi nhận bản ghi âm phần Nói của bạn trên hệ thống.
                </div>
            @endif

            @if($q->sample_answer)
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px; font-size: 13.5px; line-height: 1.6; color: #166534;">
                    <b>💡 Gợi ý / Câu trả lời mẫu chuẩn band cao:</b><br>
                    {!! nl2br(e($q->sample_answer)) !!}
                </div>
            @endif
        </div>
    @endforeach
</div>
@endsection