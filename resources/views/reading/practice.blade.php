@extends('layouts.app')

@section('title', $lesson->title . ' - Luyện Đọc TOEIC')

@push('styles')
<style>
    .reading-layout-grid {
        display: grid;
        gap: 24px;
        align-items: start;
        margin: 0 auto;
    }
    .layout-with-passage {
        grid-template-columns: 1.1fr 1fr;
        max-width: 100%;
    }
    .layout-no-passage {
        grid-template-columns: 1fr;
        max-width: 820px;
    }
</style>
@endpush

@section('content')
<div>
    <a href="{{ route('reading.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách bài đọc
    </a>

    <div class="reading-layout-grid {{ $lesson->passage ? 'layout-with-passage' : 'layout-no-passage' }}">
        <!-- Cột trái: Văn bản bài đọc (Passage) nếu có -->
        @if($lesson->passage)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; position: sticky; top: 80px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); max-height: calc(100vh - 110px); overflow-y: auto;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <span style="background: #fdf4ff; color: #a855f7; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        {{ str_replace('_', ' ', $lesson->part) }}
                    </span>
                    <span style="color: #94a3b8; font-size: 13px; font-weight: 600;">Bài {{ $lesson->order_index }}</span>
                </div>

                <h1 style="font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 16px; line-height: 1.4;">
                    {{ $lesson->title }}
                </h1>

                @if($lesson->image_url)
                    <div style="text-align: center; margin-bottom: 16px;">
                        <img src="{{ $lesson->image_url }}" alt="Hình ảnh bài đọc" style="max-width: 100%; border-radius: 10px; border: 1px solid #e2e8f0;">
                    </div>
                @endif

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; font-size: 14px; line-height: 1.75; color: #1e293b;">
                    {!! $lesson->passage !!}
                </div>
            </div>
        @endif

        <!-- Cột phải: Câu hỏi trắc nghiệm -->
        <div>
            @if(!$lesson->passage)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <span style="background: #fdf4ff; color: #a855f7; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        {{ str_replace('_', ' ', $lesson->part) }}
                    </span>
                    <h1 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 8px;">{{ $lesson->title }}</h1>
                    <p style="font-size: 13.5px; color: #64748b; margin-top: 4px;">{{ $lesson->description }}</p>
                </div>
            @endif

            <form id="readingForm">
                @csrf
                @foreach($lesson->questions as $index => $q)
                    <div class="question-card" id="q-card-{{ $q->id }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; margin-bottom: 18px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                        <div style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin-bottom: 14px; line-height: 1.5;">
                            <span style="color: #0284c7;">Câu {{ $index + 1 }}:</span> {{ $q->question }}
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr; gap: 8px; margin-bottom: 10px;">
                            @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $optKey => $optVal)
                                <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; font-size: 13.5px; font-weight: 500;" id="label-{{ $q->id }}-{{ $optKey }}">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $optKey }}" style="cursor: pointer;">
                                    <span><b>({{ $optKey }})</b> {{ $optVal }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div id="explain-{{ $q->id }}" style="display: none; margin-top: 12px; padding: 12px 14px; border-radius: 8px; font-size: 13px; line-height: 1.5;">
                            <div><b>Đáp án đúng:</b> <span style="font-weight: 800;">{{ $q->correct_answer }}</span></div>
                            <div style="margin-top: 4px;"><b>Giải thích:</b> {{ $q->explanation }}</div>
                        </div>
                    </div>
                @endforeach

                @if($lesson->questions->count() > 0)
                    <div style="text-align: center; margin-top: 20px; margin-bottom: 50px;">
                        <button type="button" id="btnSubmit" onclick="checkAnswers()" style="background: #0284c7; color: white; border: none; padding: 12px 36px; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer;">
                            Nộp bài & Xem giải thích
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<div id="readingDataHolder" data-answers="{{ json_encode($lesson->questions->pluck('correct_answer', 'id')) }}" style="display: none;"></div>

<script>
    const dataHolder = document.getElementById('readingDataHolder');
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


