@extends('layouts.app')

@section('title', 'Sổ Tay Từ Vựng & Flashcards')

@push('styles')
<style>
    .vocab-container { max-width: 900px; margin: 0 auto; }
    .vocab-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }

    /* Flashcard Section */
    .flashcard-section { 
        background: white; 
        border: 1px solid #e2e8f0; 
        border-radius: 16px; 
        padding: 30px; 
        margin-bottom: 40px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.03); 
        text-align: center; 
    }
    .card-box {
        width: 100%; max-width: 420px; height: 240px; margin: 20px auto;
        background: linear-gradient(135deg, #0284c7, #0369a1); color: white;
        border-radius: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;
        padding: 25px; cursor: pointer; box-shadow: 0 10px 25px rgba(2, 132, 199, 0.25);
        transition: transform 0.2s;
    }
    .card-box:hover { transform: scale(1.02); }
    .card-word { font-size: 32px; font-weight: 800; margin-bottom: 8px; }
    .card-ipa { font-size: 16px; color: #bae6fd; font-style: italic; margin-bottom: 12px; }
    .card-meaning { font-size: 16px; color: #ffffff; line-height: 1.5; display: none; }
    .hint-flip { font-size: 12px; color: #e0f2fe; margin-top: 15px; }

    .flash-controls { display: flex; justify-content: center; gap: 12px; margin-top: 10px; }
    .btn-ctrl { background: #f1f5f9; border: 1px solid #cbd5e1; padding: 8px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-ctrl:hover { background: #e2e8f0; }

    /* Grid danh sách từ vựng */
    .vocab-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
    .card-item { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; position: relative; display: flex; flex-direction: column; justify-content: space-between; }
    .card-item h4 { font-size: 18px; color: var(--primary); margin-bottom: 4px; display: flex; justify-content: space-between; align-items: center; }
    .item-ipa { font-size: 13px; color: #e11d48; font-style: italic; margin-bottom: 8px; font-weight: 600; }
    .item-meaning { font-size: 14px; color: #475569; line-height: 1.5; margin-bottom: 12px; }
    .btn-del { color: #ef4444; background: none; border: none; font-size: 12px; font-weight: 600; cursor: pointer; padding: 0; }
    .btn-del:hover { text-decoration: underline; }
    .btn-speak-sm { border: none; background: #f1f5f9; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; }
</style>
@endpush

@section('content')
<div class="vocab-container">
    <div class="vocab-header">
        <div>
            <a href="{{ route('courses.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 600;">&larr; Về trang chủ</a>
            <h2 style="margin-top: 6px; font-size: 24px; font-weight: 800;">Sổ Tay Từ Vựng ({{ $vocabularies->count() }} từ)</h2>
        </div>
        <div>
            <button type="button" onclick="openAddWordModal()" style="background: #0284c7; color: white; border: none; padding: 9px 18px; border-radius: 8px; font-weight: 700; font-size: 13.5px; cursor: pointer;">
                + Thêm từ mới
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    @if($vocabularies->count() > 0)
        <!-- Chế độ Flashcard lật thẻ -->
        <div class="flashcard-section">
            <h3 style="font-size: 18px; color: #475569; font-weight: 700;">Chế Độ Ôn Luyện Flashcard</h3>
            <div class="card-box" id="flashcard-box" onclick="flipCard()">
                <div class="card-word" id="fc-word">...</div>
                <div class="card-ipa" id="fc-ipa">...</div>
                <div class="card-meaning" id="fc-meaning">...</div>
                <div class="hint-flip" id="fc-hint">👉 Nhấp để xem nghĩa & phiên âm</div>
            </div>
            <div class="flash-controls">
                <button class="btn-ctrl" onclick="prevCard()">&larr; Từ trước</button>
                <button class="btn-ctrl" onclick="speakCurrentFlashcard()">🔊 Nghe phát âm</button>
                <button class="btn-ctrl" onclick="nextCard()">Từ tiếp theo &rarr;</button>
            </div>
        </div>
    @endif

    <!-- Danh sách bảng từ vựng đã lưu -->
    <h3 style="margin-bottom: 16px; font-size: 18px; font-weight: 700;">Tất cả từ vựng trong sổ</h3>
    <div class="vocab-grid">
        @forelse($vocabularies as $v)
            <div class="card-item">
                <div>
                    <h4>
                        <span>{{ $v->word }}</span>
                        <button class="btn-speak-sm" onclick="speakWord('{{ $v->word }}')" title="Nghe phát âm">🔊</button>
                    </h4>
                    <div class="item-ipa">{{ $v->ipa }}</div>
                    <div class="item-meaning">{{ $v->meaning }}</div>
                </div>
                <form action="{{ route('vocabularies.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa từ này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-del">Xóa khỏi sổ</button>
                </form>
            </div>
        @empty
            <p style="color: #94a3b8;">Chưa có từ vựng nào được lưu trong sổ tay.</p>
        @endforelse
    </div>
</div>

<!-- Modal Thêm từ mới -->
<div id="addWordModal" style="display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; padding: 26px; width: 90%; max-width: 400px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Thêm từ vựng vào sổ tay</h3>
        <form id="addWordForm" onsubmit="submitNewWord(event)">
            <div style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Từ tiếng Anh (*)</label>
                <input type="text" id="newWord" required placeholder="ví dụ: negotiate" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
            <div style="margin-bottom: 12px;">
                <label style="font-size: 13px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Phiên âm IPA</label>
                <input type="text" id="newIpa" placeholder="ví dụ: /nəˈɡoʊ.ʃi.eɪt/" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
            <div style="margin-bottom: 18px;">
                <label style="font-size: 13px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Giải nghĩa (*)</label>
                <textarea id="newMeaning" required rows="3" placeholder="ví dụ: đàm phán, thương lượng" style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; font-family: inherit;"></textarea>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" style="flex: 1; background: #0284c7; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 700; cursor: pointer;">Lưu từ</button>
                <button type="button" onclick="closeAddWordModal()" style="background: #f1f5f9; color: #64748b; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">Đóng</button>
            </div>
        </form>
    </div>
</div>

<div id="vocabJsonData" data-vocabularies="{{ json_encode($vocabularies) }}" style="display: none;"></div>
@endsection

@push('scripts')
<script>
    const dataHolder = document.getElementById('vocabJsonData');
    const vocabList = dataHolder ? JSON.parse(dataHolder.getAttribute('data-vocabularies') || '[]') : [];
    let currentIndex = 0;
    let isFlipped = false;

    function updateCard() {
        if (!vocabList || vocabList.length === 0) return;
        const current = vocabList[currentIndex];
        isFlipped = false;
        document.getElementById('fc-word').style.display = 'block';
        document.getElementById('fc-word').innerText = current.word;
        document.getElementById('fc-ipa').innerText = current.ipa || '';
        document.getElementById('fc-meaning').style.display = 'none';
        document.getElementById('fc-meaning').innerText = current.meaning;
        document.getElementById('fc-hint').innerText = '👉 Nhấp để xem giải nghĩa';
    }

    function flipCard() {
        if (!vocabList || vocabList.length === 0) return;
        isFlipped = !isFlipped;
        if (isFlipped) {
            document.getElementById('fc-meaning').style.display = 'block';
            document.getElementById('fc-hint').innerText = '👉 Nhấp để quay lại từ tiếng Anh';
        } else {
            document.getElementById('fc-meaning').style.display = 'none';
            document.getElementById('fc-hint').innerText = '👉 Nhấp để xem giải nghĩa';
        }
    }

    function nextCard() {
        if (vocabList.length === 0) return;
        currentIndex = (currentIndex + 1) % vocabList.length;
        updateCard();
    }

    function prevCard() {
        if (vocabList.length === 0) return;
        currentIndex = (currentIndex - 1 + vocabList.length) % vocabList.length;
        updateCard();
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

    function speakCurrentFlashcard() {
        if (vocabList && vocabList[currentIndex]) {
            speakWord(vocabList[currentIndex].word);
        }
    }

    function openAddWordModal() {
        document.getElementById('addWordModal').style.display = 'flex';
    }

    function closeAddWordModal() {
        document.getElementById('addWordModal').style.display = 'none';
    }

    function submitNewWord(e) {
        e.preventDefault();
        const word = document.getElementById('newWord').value.trim();
        const ipa = document.getElementById('newIpa').value.trim();
        const meaning = document.getElementById('newMeaning').value.trim();

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
            if (data.status === 'success') {
                location.reload();
            } else {
                alert(data.message || 'Có lỗi xảy ra');
            }
        });
    }

    if (vocabList.length > 0) {
        updateCard();
    }
</script>
@endpush