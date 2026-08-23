@extends('layouts.app')

@section('title', 'Đang làm bài: ' . $exam->title)

@section('content')
<div style="display: flex; gap: 24px; position: relative;">
    <!-- Cột trái: Vùng câu hỏi làm bài -->
    <div style="flex: 1; min-width: 0;">
        <form id="examForm" action="{{ route('mock_test.submit', $exam->id) }}" method="POST">
            @csrf
            <input type="hidden" name="time_spent_seconds" id="timeSpentInput" value="0">

            @if($exam->audio_url)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px 20px; margin-bottom: 20px; position: sticky; top: 76px; z-index: 50; box-shadow: 0 4px 6px rgba(0,0,0,0.03);">
                    <div style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">🎧 Audio Phần Listening:</div>
                    <audio controls style="width: 100%; outline: none;">
                        <source src="{{ $exam->audio_url }}" type="audio/mpeg">
                    </audio>
                </div>
            @endif

            @foreach($exam->questions as $q)
                <div class="question-box" id="q-section-{{ $q->id }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 800; font-size: 15px; color: #0284c7;">Câu {{ $q->question_number }} [Part {{ $q->part_number }}]</span>
                        <span style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase;">{{ $q->section }}</span>
                    </div>

                    @if($q->passage)
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; font-size: 14px; line-height: 1.6; margin-bottom: 16px;">
                            {!! $q->passage !!}
                        </div>
                    @endif

                    @if($q->image_url)
                        <div style="text-align: center; margin-bottom: 16px;">
                            <img src="{{ $q->image_url }}" alt="Hình ảnh câu hỏi" style="max-width: 100%; max-height: 280px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        </div>
                    @endif

                    @if($q->question_text)
                        <div style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin-bottom: 14px;">{{ $q->question_text }}</div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr; gap: 8px;">
                        @php
                            $opts = ['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c];
                            if ($q->option_d) $opts['D'] = $q->option_d;
                        @endphp

                        @foreach($opts as $k => $val)
                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; font-size: 13.5px; font-weight: 500;">
                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $k }}" onchange="markPaletteFilled('{{ $q->id }}')" style="cursor: pointer;">
                                <span><b>({{ $k }})</b> {{ $val }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </form>
    </div>

    <!-- Cột phải: Đồng hồ đếm ngược & Bảng chọn câu hỏi (Palette) -->
    <div style="width: 280px; flex-shrink: 0;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; position: sticky; top: 80px; box-shadow: 0 4px 6px rgba(0,0,0,0.03);">
            <div style="text-align: center; margin-bottom: 16px;">
                <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Thời gian còn lại</div>
                <div id="countdownTimer" style="font-size: 26px; font-weight: 800; color: #ef4444; font-family: monospace; margin-top: 4px;">
                    00:00:00
                </div>
            </div>

            <div style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 10px;">Bảng câu hỏi:</div>
            
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; max-height: 260px; overflow-y: auto; margin-bottom: 20px; padding-right: 4px;">
                @foreach($exam->questions as $q)
                    <a href="#q-section-{{ $q->id }}" id="pal-btn-{{ $q->id }}" style="display: flex; align-items: center; justify-content: center; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 12px; font-weight: 700; color: #475569; text-decoration: none;">
                        {{ $q->question_number }}
                    </a>
                @endforeach
            </div>

            <button type="button" onclick="confirmSubmit()" style="width: 100%; background: #0284c7; color: white; border: none; padding: 12px; border-radius: 10px; font-size: 14px; font-weight: 800; cursor: pointer;">
                Nộp bài thi
            </button>
        </div>
    </div>
</div>

<!-- Đưa thời gian vào data attribute an toàn -->
<div id="examMetaHolder" data-duration="{{ (int)$exam->duration_minutes * 60 }}" style="display: none;"></div>

<script>
    const metaHolder = document.getElementById('examMetaHolder');
    let totalSeconds = metaHolder ? parseInt(metaHolder.getAttribute('data-duration') || '7200') : 7200;
    let timeSpent = 0;

    function updateTimer() {
        if (totalSeconds <= 0) {
            document.getElementById('examForm').submit();
            return;
        }

        totalSeconds--;
        timeSpent++;
        const timeSpentInput = document.getElementById('timeSpentInput');
        if (timeSpentInput) timeSpentInput.value = timeSpent;

        let hours = Math.floor(totalSeconds / 3600);
        let mins = Math.floor((totalSeconds % 3600) / 60);
        let secs = totalSeconds % 60;

        const timerEl = document.getElementById('countdownTimer');
        if (timerEl) {
            timerEl.innerText = 
                (hours < 10 ? '0' : '') + hours + ':' + 
                (mins < 10 ? '0' : '') + mins + ':' + 
                (secs < 10 ? '0' : '') + secs;
        }
    }

    setInterval(updateTimer, 1000);
    updateTimer();

    function markPaletteFilled(qid) {
        let btn = document.getElementById('pal-btn-' + qid);
        if (btn) {
            btn.style.background = '#0284c7';
            btn.style.color = '#ffffff';
            btn.style.borderColor = '#0284c7';
        }
    }

    function confirmSubmit() {
        if (confirm('Bạn có chắc chắn muốn nộp bài để kết thúc thời gian làm bài?')) {
            document.getElementById('examForm').submit();
        }
    }
</script>
@endsection