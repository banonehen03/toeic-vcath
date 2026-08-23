@extends('layouts.app')

@section('title', 'Kết Quả Thi Thử - ' . $result->exam->title)

@push('styles')
<style>
    .result-card-correct {
        background: #ffffff;
        border: 1px solid #a7f3d0;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 16px;
    }
    .result-card-incorrect {
        background: #ffffff;
        border: 1px solid #fecaca;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 16px;
    }
    .badge-correct {
        font-size: 12px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 12px;
        background: #dcfce7;
        color: #166534;
    }
    .badge-incorrect {
        font-size: 12px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 12px;
        background: #fee2e2;
        color: #991b1b;
    }
</style>
@endpush

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 36px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.03); margin-bottom: 26px;">
        <span style="background: #ecfdf5; color: #059669; font-size: 13px; font-weight: 800; padding: 6px 14px; border-radius: 20px;">Hoàn Thành Đề Thi</span>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 12px 0 24px;">{{ $result->exam->title }}</h1>

        <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 24px;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 26px; min-width: 150px;">
                <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Listening</div>
                <div style="font-size: 26px; font-weight: 800; color: #0284c7; margin-top: 4px;">{{ $result->listening_score }}</div>
                <div style="font-size: 12px; color: #94a3b8;">{{ $result->listening_correct }} câu đúng</div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 26px; min-width: 150px;">
                <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Reading</div>
                <div style="font-size: 26px; font-weight: 800; color: #0284c7; margin-top: 4px;">{{ $result->reading_score }}</div>
                <div style="font-size: 12px; color: #94a3b8;">{{ $result->reading_correct }} câu đúng</div>
            </div>

            <div style="background: #eff6ff; border: 2px solid #0284c7; border-radius: 12px; padding: 18px 26px; min-width: 170px;">
                <div style="font-size: 12px; font-weight: 800; color: #0284c7; text-transform: uppercase;">Tổng Điểm TOEIC</div>
                <div style="font-size: 32px; font-weight: 800; color: #0284c7; margin-top: 2px;">{{ $result->total_score }}</div>
                <div style="font-size: 12px; color: #64748b;">Thang điểm 990</div>
            </div>
        </div>

        <a href="{{ route('mock_test.index') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #0284c7; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px;">
            &larr; Trở về danh sách đề thi
        </a>
    </div>

    <!-- Chi tiết đáp án đúng / sai và giải thích -->
    <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Chi Tiết Từng Câu Hỏi & Lời Giải</h2>

    @foreach($result->exam->questions as $q)
        @php
            $userAns = $result->user_answers[$q->id] ?? null;
            $isCorrect = ($userAns && strtoupper($userAns) === strtoupper($q->correct_answer));
        @endphp
        <div class="{{ $isCorrect ? 'result-card-correct' : 'result-card-incorrect' }}">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                <span style="font-weight: 800; font-size: 14px; color: #0f172a;">Câu {{ $q->question_number }} [Part {{ $q->part_number }}]</span>
                <span class="{{ $isCorrect ? 'badge-correct' : 'badge-incorrect' }}">
                    {{ $isCorrect ? 'ĐÚNG' : 'CHƯA ĐÚNG' }}
                </span>
            </div>

            @if($q->question_text)
                <p style="font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 10px;">{{ $q->question_text }}</p>
            @endif

            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                Bạn chọn: <b>{{ $userAns ? '(' . $userAns . ')' : 'Chưa chọn' }}</b> | Đáp án chuẩn: <b style="color: #059669;">({{ $q->correct_answer }})</b>
            </div>

            @if($q->explanation)
                <div style="background: #f8fafc; border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #475569; line-height: 1.5;">
                    <b>Giải thích:</b> {{ $q->explanation }}
                </div>
            @endif
        </div>
    @endforeach
</div>
@endsection