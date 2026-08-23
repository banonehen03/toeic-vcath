@extends('layouts.app')

@section('title', 'Kết Quả Bài Luyện Thi TOEIC')

@push('styles')
<style>
    .result-container { max-width: 800px; margin: 0 auto; }
    .score-box { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; text-align: center; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .score-num { font-size: 48px; font-weight: 800; color: var(--primary); margin: 10px 0; }
    
    .result-item { background: white; border-radius: 12px; padding: 20px; margin-bottom: 16px; border: 1px solid #e2e8f0; }
    .is-correct { border-left: 5px solid #10b981; }
    .is-wrong { border-left: 5px solid #ef4444; }
    .badge { padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 700; }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .explain-box { margin-top: 10px; font-size: 14px; background: #f8fafc; padding: 10px 14px; border-radius: 8px; color: #475569; }
    .btn-again { display: inline-block; background: #0284c7; color: white; text-decoration: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; margin-top: 15px; transition: background 0.2s; }
    .btn-again:hover { background: #0369a1; }
</style>
@endpush

@section('content')
<div class="result-container">
    <div class="score-box">
        <h2>Kết Quả Làm Bài</h2>
        <div class="score-num">{{ $score }} / {{ $total }}</div>
        <p style="color: var(--text-muted); font-size: 15px;">Đạt tỷ lệ: <b>{{ $percentage ?? round(($score / max($total, 1)) * 100) }}%</b></p>
        <a href="{{ route('quiz.index') }}" class="btn-again">Làm lại bài thi</a>
        <a href="{{ route('courses.index') }}" style="margin-left: 12px; color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 600;">Về trang chủ</a>
    </div>

    <h3 style="margin-bottom: 16px; font-size: 18px; font-weight: 700;">Chi tiết đáp án & Giải thích</h3>

    @foreach($results as $index => $r)
        <div class="result-item {{ $r['isCorrect'] ? 'is-correct' : 'is-wrong' }}">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; gap: 10px;">
                <b style="line-height: 1.5;">Câu {{ $index + 1 }}: {{ $r['question'] }}</b>
                @if($r['isCorrect'])
                    <span class="badge badge-success">✓ Đúng</span>
                @else
                    <span class="badge badge-danger">✗ Sai</span>
                @endif
            </div>

            <div style="font-size: 14px; margin-bottom: 6px;">
                Đáp án bạn chọn: <b>({{ $r['chosen'] ?? 'Chưa chọn' }})</b> | Đáp án đúng: <b style="color: var(--primary);">({{ $r['correct'] }})</b>
            </div>

            <div class="explain-box">
                💡 <b>Giải thích chi tiết:</b> {{ $r['explanation'] }}
            </div>
        </div>
    @endforeach
</div>
@endsection