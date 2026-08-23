@extends('layouts.app')

@section('title', 'Luyện tập: ' . $lesson->title)

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    <a href="{{ route('grammar_practice.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách chủ đề
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">{{ $lesson->level }}</span>
            <span style="color: #94a3b8; font-size: 13px; font-weight: 600;">Chủ đề {{ $lesson->order_index }}</span>
        </div>
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
            Luyện tập: {{ $lesson->title }}
        </h1>
        <p style="color: #64748b; font-size: 14px;">Chọn 1 đáp án đúng nhất cho mỗi câu hỏi bên dưới và bấm nút <b>Nộp bài</b> để xem giải thích.</p>
    </div>

    <form id="practiceForm">
        @csrf
        @forelse($lesson->questions as $index => $q)
            <div class="question-card" id="q-card-{{ $q->id }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 16px; line-height: 1.5;">
                    <span style="color: #0284c7;">Câu {{ $index + 1 }}:</span> {{ $q->question }}
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                    @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $optKey => $optVal)
                        <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.2s;" id="label-{{ $q->id }}-{{ $optKey }}">
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $optKey }}" style="cursor: pointer;">
                            <span><b>{{ $optKey }}.</b> {{ $optVal }}</span>
                        </label>
                    @endforeach
                </div>

                <!-- Khu vực giải thích đáp án -->
                <div id="explain-{{ $q->id }}" style="display: none; margin-top: 14px; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; line-height: 1.5;">
                    <div><b>Đáp án đúng:</b> <span style="font-weight: 800;">{{ $q->correct_answer }}</span></div>
                    <div style="margin-top: 4px;"><b>Giải thích:</b> {{ $q->explanation }}</div>
                </div>
            </div>
        @empty
            <div style="background: white; padding: 24px; border-radius: 12px; text-align: center; color: #64748b; border: 1px solid #e2e8f0;">
                Chưa có câu hỏi trắc nghiệm nào cho chủ đề này.
            </div>
        @endforelse

        @if($lesson->questions->count() > 0)
            <div style="text-align: center; margin-top: 30px; margin-bottom: 50px;">
                <button type="button" id="btnSubmit" onclick="checkAnswers()" style="background: #0284c7; color: white; border: none; padding: 12px 36px; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: background 0.2s;">
                    Nộp bài & Chấm điểm
                </button>
            </div>
        @endif
    </form>
</div>

<!-- Chứa dữ liệu an toàn dạng data attribute -->
<div id="practiceDataHolder" data-answers="{{ json_encode($lesson->questions->pluck('correct_answer', 'id')) }}" style="display: none;"></div>

<script>
    const dataHolder = document.getElementById('practiceDataHolder');
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

        let btn = document.getElementById('btnSubmit');
        if (btn) {
            btn.innerText = 'Kết quả: ' + score + '/' + total + ' Câu Đúng - Làm lại';
            btn.onclick = function() { location.reload(); };
            btn.style.background = '#059669';
        }
    }
</script>
@endsection