@extends('layouts.app')

@section('title', $category->name . ' - Học Từ Vựng TOEIC')

@push('styles')
<style>
    .topic-container { max-width: 860px; margin: 0 auto; }
    
    /* Flashcard Style */
    .flashcard-section {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 35px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        text-align: center;
    }
    .card-box {
        width: 100%;
        max-width: 460px;
        min-height: 240px;
        margin: 20px auto;
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: white;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 25px;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(2, 132, 199, 0.25);
        transition: transform 0.2s;
    }
    .card-box:hover { transform: scale(1.02); }
    .card-word { font-size: 32px; font-weight: 800; margin-bottom: 6px; }
    .card-ipa { font-size: 15px; color: #bae6fd; font-style: italic; margin-bottom: 8px; }
    .card-pos { font-size: 12px; background: rgba(255,255,255,0.2); padding: 2px 10px; border-radius: 10px; margin-bottom: 12px; }
    .card-meaning { font-size: 18px; font-weight: 700; color: #ffffff; line-height: 1.5; display: none; }
    .card-example { font-size: 13.5px; color: #e0f2fe; font-style: italic; margin-top: 10px; display: none; }
    .hint-flip { font-size: 12px; color: #e0f2fe; margin-top: 15px; }

    .flash-controls { display: flex; justify-content: center; align-items: center; gap: 12px; margin-top: 15px; }
    .btn-ctrl { background: #f1f5f9; border: 1px solid #cbd5e1; padding: 8px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; }
    .btn-ctrl:hover { background: #e2e8f0; }

    /* Word List Item */
    .word-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .btn-speak-sm { border: none; background: #f1f5f9; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; }
</style>
@endpush

@section('content')
<div class="topic-container">
    <a href="{{ route('vocabularies.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh mục từ vựng
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">{{ $category->name }}</h1>
        <p style="color: #64748b; font-size: 14px;">{{ $category->description }}</p>
    </div>

    @if($category->words->count() > 0)
        <!-- Flashcard Section -->
        <div class="flashcard-section">
            <h3 style="font-size: 16px; color: #475569; font-weight: 700;">Chế Độ Flashcard Ghi Nhớ</h3>
            <div class="card-box" id="flashcard-box" onclick="flipCard()">
                <div class="card-word" id="fc-word">...</div>
                <div class="card-ipa" id="fc-ipa">...</div>
                <div class="card-pos" id="fc-pos">...</div>
                <div class="card-meaning" id="fc-meaning">...</div>
                <div class="card-example" id="fc-example">...</div>
                <div class="hint-flip" id="fc-hint">👉 Nhấp để xem nghĩa & ví dụ</div>
            </div>
            <div class="flash-controls">
                <button type="button" class="btn-ctrl" onclick="prevCard()">&larr; Từ trước</button>
                <span id="cardCounter" style="font-weight: 700; color: #475569; font-size: 14px;">1 / {{ $category->words->count() }}</span>
                <button type="button" class="btn-ctrl" onclick="speakCurrentWord()">🔊 Phát âm</button>
                <button type="button" class="btn-ctrl" onclick="nextCard()">Từ tiếp theo &rarr;</button>
            </div>
        </div>
    @endif

    <!-- Danh sách toàn bộ từ vựng trong chủ đề -->
    <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Tất Cả Từ Vựng Trong Bài ({{ $category->words->count() }} từ)</h2>

    @forelse($category->words as $w)
        <div class="word-card">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span style="font-size: 18px; font-weight: 800; color: #0284c7;">{{ $w->word }}</span>
                    @if($w->phonetic)
                        <span style="font-size: 13.5px; color: #64748b;">{{ $w->phonetic }}</span>
                    @endif
                    @if($w->part_of_speech)
                        <span style="background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 8px;">({{ $w->part_of_speech }})</span>
                    @endif
                    <button type="button" class="btn-speak-sm" onclick="speakWord('{{ $w->word }}')" title="Phát âm">🔊</button>
                </div>
                <div style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">{{ $w->meaning_vi }}</div>
                @if($w->example_sentence)
                    <div style="font-size: 13.5px; color: #475569; font-style: italic;">"{{ $w->example_sentence }}"</div>
                    @if($w->example_translation)
                        <div style="font-size: 12.5px; color: #94a3b8;">{{ $w->example_translation }}</div>
                    @endif
                @endif
            </div>

            <!-- Nút lưu nhanh vào Sổ tay cá nhân -->
            <button type="button" onclick="saveToNotebook('{{ $w->word }}', '{{ $w->phonetic }}', '{{ $w->meaning_vi }}')" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 8px 12px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer; flex-shrink: 0;">
                + Lưu vào sổ tay
            </button>
        </div>
    @empty
        <p style="color: #94a3b8;">Chưa có từ vựng trong chủ đề này.</p>
    @endforelse
</div>

<div id="topicWordsData" data-words="{{ json_encode($category->words) }}" style="display: none;"></div>
@endsection

@push('scripts')
<script>
    const dataHolder = document.getElementById('topicWordsData');
    const wordList = dataHolder ? JSON.parse(dataHolder.getAttribute('data-words') || '[]') : [];
    let currentIndex = 0;
    let isFlipped = false;

    function renderCard() {
        if (wordList.length === 0) return;
        const current = wordList[currentIndex];
        isFlipped = false;

        document.getElementById('fc-word').style.display = 'block';
        document.getElementById('fc-word').innerText = current.word;
        document.getElementById('fc-ipa').innerText = current.phonetic || '';
        document.getElementById('fc-pos').innerText = current.part_of_speech ? '(' + current.part_of_speech + ')' : '';

        document.getElementById('fc-meaning').style.display = 'none';
        document.getElementById('fc-meaning').innerText = current.meaning_vi;

        document.getElementById('fc-example').style.display = 'none';
        document.getElementById('fc-example').innerText = current.example_sentence ? '"' + current.example_sentence + '"' : '';

        document.getElementById('fc-hint').innerText = '👉 Nhấp để xem nghĩa & ví dụ';
        document.getElementById('cardCounter').innerText = (currentIndex + 1) + ' / ' + wordList.length;
    }

    function flipCard() {
        if (wordList.length === 0) return;
        isFlipped = !isFlipped;

        if (isFlipped) {
            document.getElementById('fc-meaning').style.display = 'block';
            document.getElementById('fc-example').style.display = 'block';
            document.getElementById('fc-hint').innerText = '👉 Nhấp để quay lại từ vựng';
        } else {
            document.getElementById('fc-meaning').style.display = 'none';
            document.getElementById('fc-example').style.display = 'none';
            document.getElementById('fc-hint').innerText = '👉 Nhấp để xem nghĩa & ví dụ';
        }
    }

    function nextCard() {
        if (wordList.length === 0) return;
        currentIndex = (currentIndex + 1) % wordList.length;
        renderCard();
    }

    function prevCard() {
        if (wordList.length === 0) return;
        currentIndex = (currentIndex - 1 + wordList.length) % wordList.length;
        renderCard();
    }

    function speakWord(word) {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(word);
            utterance.lang = 'en-US';
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }
    }

    function speakCurrentWord() {
        if (wordList && wordList[currentIndex]) {
            speakWord(wordList[currentIndex].word);
        }
    }

    function saveToNotebook(word, ipa, meaning) {
        fetch("{{ route('vocabularies.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ word, ipa, meaning })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Đã thêm vào sổ tay thành công!');
        });
    }

    if (wordList.length > 0) {
        renderCard();
    }
</script>
@endpush