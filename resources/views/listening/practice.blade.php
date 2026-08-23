@extends('layouts.app')

@section('title', $lesson->title . ' - Luyện Nghe TOEIC')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    <a href="{{ route('listening.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách bài nghe
    </a>

    <!-- Header & Audio Player -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <span style="background: #f0fdf4; color: #16a34a; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">{{ str_replace('_', ' ', $lesson->part) }}</span>
            <span style="color: #94a3b8; font-size: 13px; font-weight: 600;">Bài {{ $lesson->order_index }}</span>
        </div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
            {{ $lesson->title }}
        </h1>

        @if($lesson->image_url)
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="{{ $lesson->image_url }}" alt="Hình ảnh câu hỏi" style="max-width: 100%; max-height: 360px; border-radius: 12px; object-fit: cover; border: 1px solid #e2e8f0;">
            </div>
        @endif

        @if($lesson->audio_url)
            <div style="background: #f8fafc; padding: 14px 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 14px;">
                <span style="font-size: 14px; font-weight: 700; color: #334155;">🎧 Audio Bài Nghe:</span>
                <audio controls style="flex: 1; outline: none;">
                    <source src="{{ $lesson->audio_url }}" type="audio/mpeg">
                    Trình duyệt của bạn không hỗ trợ phát Audio.
                </audio>
            </div>
        @endif
    </div>

    <!-- Danh sách câu hỏi -->
    <form id="listeningForm">
        @csrf
        @forelse($lesson->questions as $index => $q)
            <div class="question-card" id="q-card-{{ $q->id }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 16px; line-height: 1.5;">
                    <span style="color: #0284c7;">Câu {{ $index + 1 }}:</span> {{ $q->question }}
                </div>

                <div style="display: grid; grid-template-columns: 1fr; gap: 10px; margin-bottom: 12px;">
                    @php
                        $options = ['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c];
                        if ($q->option_d) $options['D'] = $q->option_d;
                    @endphp

                    @foreach($options as $optKey => $optVal)
                        <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500;" id="label-{{ $q->id }}-{{ $optKey }}">
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $optKey }}" style="cursor: pointer;">
                            <span><b>({{ $optKey }})</b> {{ $optVal }}</span>
                        </label>
                    @endforeach
                </div>

                <div id="explain-{{ $q->id }}" style="display: none; margin-top: 14px; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; line-height: 1.5;">
                    <div><b>Đáp án đúng:</b> <span style="font-weight: 800;">{{ $q->correct_answer }}</span></div>
                    <div style="margin-top: 4px;"><b>Giải thích:</b> {{ $q->explanation }}</div>
                </div>
            </div>
        @empty
            <p style="color: #64748b;">Chưa có câu hỏi.</p>
        @endforelse

        @if($lesson->questions->count() > 0)
            <div style="text-align: center; margin-top: 24px; margin-bottom: 30px;">
                <button type="button" id="btnSubmit" onclick="checkAnswers()" style="background: #0284c7; color: white; border: none; padding: 12px 36px; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer;">
                    Nộp bài & Xem Transcript
                </button>
            </div>
        @endif
    </form>

    <!-- Transcript bài nghe (Ẩn mặc định) -->
    @if($lesson->transcript)
        <div id="transcriptBox" style="display: none; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 40px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                📝 Lời Thoại (Transcript) & Dịch nghĩa
            </h3>
            <div style="font-size: 14px; line-height: 1.8; color: #334155;">
                {!! $lesson->transcript !!}
            </div>
        </div>
    @endif
</div>

<div id="listeningDataHolder" data-answers="{{ json_encode($lesson->questions->pluck('correct_answer', 'id')) }}" style="display: none;"></div>

<script>
    const dataHolder = document.getElementById('listeningDataHolder');
    const correctData = dataHolder ? JSON.parse(dataHolder.getAttribute('data-answers') || '{}') : {};

    function checkAnswers() {
        let score = 0;
        const qIds = Object.keys(correctData);
        let total = qIds.length;

        if (total === 0) return;

        qIds.forEach(qId => {
            let correct = correctData[qId];
            let selected = document.querySelector('input[name="answers[' + qId + ']"]:checked');
            let explainBox = document.getElementById('explain-' + qId);
            
            if (explainBox) {
                explainBox.style.display = 'block';

                if (selected && selected.value === correct) {
                    score++;
                    explainBox.style.background = '#ecfdf5';
                    explainBox.style.border = '1px solid #a7f3d0';
                    explainBox.style.color = '#065f46';
                    let correctLabel = document.getElementById('label-' + qId + '-' + correct);
                    if (correctLabel) correctLabel.style.background = '#d1fae5';
                } else {
                    explainBox.style.background = '#fef2f2';
                    explainBox.style.border = '1px solid #fecaca';
                    explainBox.style.color = '#991b1b';
                    if (selected) {
                        let selectedLabel = document.getElementById('label-' + qId + '-' + selected.value);
                        if (selectedLabel) selectedLabel.style.background = '#fee2e2';
                    }
                    let correctLabel = document.getElementById('label-' + qId + '-' + correct);
                    if (correctLabel) correctLabel.style.background = '#d1fae5';
                }
            }
        });

        // Hiển thị phần Transcript
        const transcriptBox = document.getElementById('transcriptBox');
        if (transcriptBox) {
            transcriptBox.style.display = 'block';
        }

        let btn = document.getElementById('btnSubmit');
        if (btn) {
            btn.innerText = 'Kết quả: ' + score + '/' + total + ' Câu Đúng - Làm lại';
            btn.onclick = function() { location.reload(); };
            btn.style.background = '#059669';
        }
    }
</script>
@endsection