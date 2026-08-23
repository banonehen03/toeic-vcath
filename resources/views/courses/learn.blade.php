@extends('layouts.learning')

@section('title', $currentLesson->title . ' - ' . $course->title)

@section('sidebar')
    <a href="{{ route('courses.index') }}" class="back-link">&larr; Về trang chủ</a>
    <h3>{{ $course->title }}</h3>
    <span class="course-level">{{ $course->level }}</span>
    
    <div class="lesson-list">
        @foreach($course->lessons as $lesson)
            <a href="{{ route('courses.learn', [$course->id, $lesson->id]) }}" 
               class="lesson-item {{ $lesson->id == $currentLesson->id ? 'active' : '' }}">
                Bài {{ $lesson->order_number }}: {{ $lesson->title }}
            </a>
        @endforeach
    </div>
@endsection

@section('content')
    <div class="lesson-header">
        <h2>{{ $currentLesson->title }}</h2>
        <div class="hint-bar">
            💡 <b>Mẹo học:</b> Bôi đen từ vựng để tra nghĩa, bấm 🔊 nghe phát âm hoặc bấm ⭐ để lưu vào sổ từ vựng ôn tập.
        </div>
    </div>

    @if(!empty($currentLesson->video_url))
        <div class="video-container">
            <iframe src="{{ $currentLesson->video_url }}" allowfullscreen></iframe>
        </div>
    @endif

    <div class="reading-card" id="reading-content">
        {!! nl2br(e($currentLesson->content)) !!}
    </div>
@endsection

@push('scripts')
<script>
    const API_BASE_URL = 'https://api-tudien-anhviet.onrender.com';

    const popup = document.getElementById('dict-popup');
    const readingArea = document.getElementById('reading-content');
    
    let currentWordText = '';
    let currentWordIpa = '';
    let currentWordMeaning = '';

    // Hàm phát âm Audio TTS
    function speakCurrentWord() {
        if ('speechSynthesis' in window && currentWordText) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(currentWordText);
            utterance.lang = 'en-US';
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }
    }

    // Hàm lưu từ vựng vào Sổ tay
    async function saveCurrentWord() {
        if (!currentWordText) return;

        try {
            const res = await fetch("{{ route('vocabularies.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    word: currentWordText,
                    ipa: currentWordIpa,
                    meaning: currentWordMeaning || 'Nghĩa từ vựng'
                })
            });

            const data = await res.json();
            const msgBox = document.getElementById('save-msg');
            msgBox.innerText = '✓ ' + (data.message || 'Đã lưu vào Sổ tay!');
            msgBox.style.display = 'block';
            setTimeout(() => { msgBox.style.display = 'none'; }, 2500);
        } catch (e) {
            alert('Không thể lưu từ vựng vào hệ thống.');
        }
    }

    // Bắt sự kiện bôi đen từ trong bài đọc
    readingArea.addEventListener('mouseup', async function(e) {
        const selectedText = window.getSelection().toString().trim();

        if (selectedText.length >= 2 && !selectedText.includes(' ')) {
            currentWordText = selectedText;
            const x = e.pageX + 12;
            const y = e.pageY + 12;

            popup.style.left = x + 'px';
            popup.style.top = y + 'px';
            popup.style.display = 'block';
            document.getElementById('save-msg').style.display = 'none';
            
            document.getElementById('pop-word').innerText = selectedText;
            document.getElementById('pop-ipa').innerText = 'Đang tra cứu...';
            document.getElementById('pop-definitions').innerHTML = '';

            try {
                const res = await fetch(`${API_BASE_URL}/lookup.php?keyword=${encodeURIComponent(selectedText)}`);
                const data = await res.json();

                if (data.status === 'success') {
                    currentWordIpa = data.data.pronunciations[0]?.ipa ? `/${data.data.pronunciations[0].ipa}/` : '';
                    currentWordMeaning = data.data.definitions.map(d => `[${d.pos || 'Từ'}] ${d.meaning}`).join('; ');

                    document.getElementById('pop-word').innerText = data.data.word;
                    document.getElementById('pop-ipa').innerText = currentWordIpa;
                    
                    let defHtml = '';
                    data.data.definitions.slice(0, 4).forEach(d => {
                        defHtml += `<div class="meaning-item"><span class="pos">[${d.pos || 'N/A'}]</span> ${d.meaning}</div>`;
                    });
                    document.getElementById('pop-definitions').innerHTML = defHtml;

                    // Tự động phát âm khi bôi đen từ
                    speakCurrentWord();
                } else {
                    currentWordIpa = '';
                    currentWordMeaning = '';
                    document.getElementById('pop-ipa').innerText = '';
                    document.getElementById('pop-definitions').innerHTML = `<span style="color: #ef4444; font-size: 13px;">${data.message}</span>`;
                }
            } catch (err) {
                currentWordIpa = '';
                currentWordMeaning = '';
                document.getElementById('pop-ipa').innerText = '';
                document.getElementById('pop-definitions').innerHTML = `<span style="color: #ef4444; font-size: 13px;">Không thể kết nối API từ điển</span>`;
            }
        } else {
            popup.style.display = 'none';
        }
    });

    // Click ra ngoài vùng để ẩn popup
    document.addEventListener('mousedown', function(e) {
        if (!popup.contains(e.target) && !readingArea.contains(e.target)) {
            popup.style.display = 'none';
        }
    });
</script>
@endpush