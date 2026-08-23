@extends('layouts.app')

@section('title', 'Luyện Đề Thi Thử TOEIC Mini Test')

@push('styles')
<style>
    .quiz-container { max-width: 800px; margin: 0 auto; }
    .quiz-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .timer-badge { background: #fee2e2; color: #dc2626; padding: 8px 16px; border-radius: 20px; font-weight: 700; font-size: 15px; }
    
    .q-card { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
    .q-title { font-size: 16px; font-weight: 700; margin-bottom: 16px; line-height: 1.6; }
    .options-list { display: flex; flex-direction: column; gap: 10px; }
    .opt-label { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s; font-size: 14px; }
    .opt-label:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .opt-label input { accent-color: var(--primary); width: 16px; height: 16px; }

    .btn-submit-quiz { background: var(--primary); color: white; border: none; padding: 14px 30px; font-size: 16px; font-weight: 700; border-radius: 10px; cursor: pointer; width: 100%; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25); transition: background 0.2s; }
    .btn-submit-quiz:hover { background: #047857; }
</style>
@endpush

@section('content')
<div class="quiz-container">
    <div class="quiz-header">
        <div>
            <a href="{{ route('courses.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 600;">&larr; Về trang chủ</a>
            <h2 style="margin-top: 6px;">Luyện Đề TOEIC Mini Test</h2>
        </div>
        <div class="timer-badge" id="timer">⏱️ 05:00</div>
    </div>

    <form action="{{ route('quiz.submit') }}" method="POST" id="quizForm">
        @csrf
        @foreach($questions as $index => $q)
            <div class="q-card">
                <div class="q-title">Câu {{ $index + 1 }}: {{ $q->question_text }}</div>
                <div class="options-list">
                    <label class="opt-label">
                        <input type="radio" name="answers[{{ $q->id }}]" value="A" required>
                        (A) {{ $q->option_a }}
                    </label>
                    <label class="opt-label">
                        <input type="radio" name="answers[{{ $q->id }}]" value="B">
                        (B) {{ $q->option_b }}
                    </label>
                    <label class="opt-label">
                        <input type="radio" name="answers[{{ $q->id }}]" value="C">
                        (C) {{ $q->option_c }}
                    </label>
                    <label class="opt-label">
                        <input type="radio" name="answers[{{ $q->id }}]" value="D">
                        (D) {{ $q->option_d }}
                    </label>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn-submit-quiz">Nộp bài & Chấm điểm</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Bộ đếm ngược thời gian 5 phút
    let timeLeft = 300;
    const timerEl = document.getElementById('timer');

    const interval = setInterval(() => {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerEl.innerText = `⏱️ 0${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        if (timeLeft <= 0) {
            clearInterval(interval);
            alert('Hết giờ làm bài! Hệ thống đang tự động nộp bài của bạn.');
            document.getElementById('quizForm').submit();
        }
        timeLeft--;
    }, 1000);
</script>
@endpush