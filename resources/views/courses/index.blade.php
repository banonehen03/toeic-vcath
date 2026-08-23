@extends('layouts.app')

@section('title', 'Học Tiếng Anh Online & Luyện Thi TOEIC - TOEIC VCATH')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        margin-bottom: 50px;
    }
    .hero-left { flex: 1.2; }
    .hero-title {
        font-size: 46px;
        font-weight: 800;
        line-height: 1.15;
        color: #0f172a;
        margin-bottom: 18px;
    }
    .hero-title span {
        color: var(--primary);
        display: block;
    }
    .hero-desc {
        font-size: 16px;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 28px;
        max-width: 500px;
    }
    .hero-actions { display: flex; gap: 14px; align-items: center; }
    .btn-primary-action {
        background: var(--primary);
        color: white;
        padding: 13px 26px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
        border: none;
        cursor: pointer;
    }
    .btn-secondary-action {
        background: #ffffff;
        color: #0f172a;
        border: 1px solid #e2e8f0;
        padding: 13px 24px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
    }

    .hero-right { flex: 0.9; text-align: right; }
    .hero-card-img {
        width: 100%;
        max-width: 380px;
        height: 280px;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 4px solid #ffffff;
    }

    /* Stats Section */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding: 30px 0;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 50px;
    }
    .stat-item h3 { font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .stat-item p { font-size: 13px; color: var(--text-muted); font-weight: 500; }

    /* Dictionary Box Section */
    .dict-section {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 50px;
    }
    .search-box-wrapper { position: relative; display: flex; gap: 12px; margin-top: 16px; }
    .search-box-wrapper input {
        flex: 1;
        padding: 14px 20px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        font-size: 15px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s;
    }
    .search-box-wrapper input:focus { border-color: var(--primary); }
    .search-box-wrapper button {
        background: var(--primary);
        color: white;
        padding: 0 28px;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }
    .suggest-dropdown {
        position: absolute;
        top: 55px;
        left: 0;
        width: calc(100% - 130px);
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        max-height: 180px;
        overflow-y: auto;
        display: none;
        z-index: 50;
    }
    .suggest-item { padding: 10px 16px; cursor: pointer; font-size: 14px; }
    .suggest-item:hover { background: #f8fafc; color: var(--primary); }
    .dict-result-card {
        margin-top: 20px;
        padding: 20px;
        background: #ecfdf5;
        border-radius: 12px;
        display: none;
        border-left: 4px solid var(--primary);
    }

    /* Courses Grid */
    .section-header { margin-bottom: 24px; }
    .section-header h2 { font-size: 24px; font-weight: 800; }
    .course-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
    .course-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .course-card:hover { transform: translateY(-3px); box-shadow: 0 12px 20px rgba(0,0,0,0.05); }
    .course-badge {
        align-self: flex-start;
        background: #e0f2fe;
        color: #0369a1;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        margin-bottom: 12px;
    }
    .course-price { font-size: 20px; font-weight: 800; color: #0284c7; margin: 15px 0; }
    .btn-course-enroll {
        background: #0f172a;
        color: white;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-course-enroll:hover { background: #1e293b; }
</style>
@endpush

@section('content')
    <!-- Hero Banner -->
    <section class="hero">
        <div class="hero-left">
            <h1 class="hero-title">
                Luyện thi thông minh,
                <span>Chinh phục TOEIC 450+</span>
            </h1>
            <p class="hero-desc">
                Nền tảng học và tra từ vựng tích hợp trực tiếp trên từng bài đọc. Tra cứu nghĩa, phiên âm IPA tức thì không gián đoạn quá trình làm bài.
            </p>
            <div class="hero-actions">
                <a href="#courses-area" class="btn-primary-action">
                    Bắt đầu học ngay &rarr;
                </a>
                <a href="#dictionary-area" class="btn-secondary-action">
                    Tra cứu từ điển
                </a>
            </div>
        </div>
        <div class="hero-right">
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80" alt="Học viên" class="hero-card-img">
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="stats-bar">
        <div class="stat-item">
            <h3>120,000+</h3>
            <p>Từ vựng trong Database</p>
        </div>
        <div class="stat-item">
            <h3>75+</h3>
            <p>Đề thi thử chuẩn format</p>
        </div>
        <div class="stat-item">
            <h3>7,700+</h3>
            <p>Câu hỏi luyện nghe Audio</p>
        </div>
        <div class="stat-item">
            <h3>23,500+</h3>
            <p>Học viên đang ôn luyện</p>
        </div>
    </section>

    <!-- Khung Tra Từ Điển (Khách tự do sử dụng) -->
    <section class="dict-section" id="dictionary-area">
        <h3 style="font-size: 20px; font-weight: 700;">Tra từ điển nhanh (API Service)</h3>
        <p style="color: var(--text-muted); font-size: 14px; margin-top: 4px;">Nhập từ tiếng Anh để xem phiên âm IPA và giải nghĩa chi tiết.</p>

        <div class="search-box-wrapper">
            <input type="text" id="dict-input" placeholder="Nhập từ vựng (ví dụ: contract, negotiate, developer)..." autocomplete="off">
            <button onclick="searchWord()">Tra cứu</button>
            <div id="suggest-box" class="suggest-dropdown"></div>
        </div>

        <div id="dict-result" class="dict-result-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                <h4 id="res-word" style="font-size: 22px; color: var(--primary); margin: 0;"></h4>
                <button id="btn-home-speak" onclick="speakHomeWord()" style="background: #ffffff; border: 1px solid #cbd5e1; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);" title="Nghe phát âm">
                    🔊
                </button>
            </div>
            <div id="res-ipa" style="color: #e11d48; font-style: italic; font-size: 15px; margin-bottom: 12px; font-weight: 600;"></div>
            <div id="res-meanings" style="font-size: 15px; line-height: 1.7;"></div>
        </div>
    </section>

    <!-- Danh sách khóa học (Khách xem được, bấm vào học sẽ mở modal) -->
    <section id="courses-area">
        <div class="section-header">
            <h2>Khóa Học & Lộ Trình Đào Tạo</h2>
        </div>

        <div class="course-grid">
            @foreach($courses as $course)
                <div class="course-card">
                    <div>
                        <span class="course-badge">{{ $course->level }}</span>
                        <h3 style="font-size: 18px; margin-bottom: 8px;">{{ $course->title }}</h3>
                        <p style="color: var(--text-muted); font-size: 14px; line-height: 1.5;">{{ $course->description }}</p>
                    </div>

                    <div>
                        <div class="course-price">{{ number_format($course->price, 0, ',', '.') }} VNĐ</div>
                        @auth
                            <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-course-enroll">Vào học ngay</button>
                            </form>
                        @else
                            <button type="button" onclick="openAuthModal('tham gia khóa học: {{ $course->title }}')" class="btn-course-enroll">
                                Vào học ngay 🔒
                            </button>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const API_BASE_URL = 'https://api-tudien-anhviet.onrender.com';

    const input = document.getElementById('dict-input');
    const suggestBox = document.getElementById('suggest-box');
    const resultBox = document.getElementById('dict-result');
    let currentLookupWord = '';

    // Phát âm Audio TTS chuẩn bản xứ US
    function speakHomeWord() {
        if ('speechSynthesis' in window && currentLookupWord) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(currentLookupWord);
            utterance.lang = 'en-US';
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }
    }

    // Gợi ý từ khi gõ (Autocomplete)
    input.addEventListener('input', async function() {
        const val = this.value.trim();
        if (val.length >= 2) {
            try {
                const res = await fetch(`${API_BASE_URL}/suggest.php?q=${encodeURIComponent(val)}&limit=5`);
                const data = await res.json();
                if (data.status === 'success' && data.data.length > 0) {
                    suggestBox.innerHTML = data.data.map(item => `<div class="suggest-item" onclick="selectWord('${item.word}')">${item.word}</div>`).join('');
                    suggestBox.style.display = 'block';
                } else {
                    suggestBox.style.display = 'none';
                }
            } catch(e) {
                suggestBox.style.display = 'none';
            }
        } else {
            suggestBox.style.display = 'none';
        }
    });

    function selectWord(word) {
        input.value = word;
        suggestBox.style.display = 'none';
        searchWord();
    }

    // Tra cứu chi tiết
    async function searchWord() {
        const word = input.value.trim();
        if (!word) return;

        currentLookupWord = word;

        try {
            const res = await fetch(`${API_BASE_URL}/lookup.php?keyword=${encodeURIComponent(word)}`);
            const data = await res.json();

            if (data.status === 'success') {
                document.getElementById('res-word').innerText = data.data.word;
                document.getElementById('res-ipa').innerText = data.data.pronunciations[0]?.ipa ? `Phiên âm: /${data.data.pronunciations[0].ipa}/` : '';
                
                let html = '';
                data.data.definitions.forEach(d => {
                    html += `<div style="margin-bottom: 6px;"><b>[${d.pos || 'Từ'}]</b> ${d.meaning}</div>`;
                });
                document.getElementById('res-meanings').innerHTML = html;
                resultBox.style.display = 'block';

                // Tự động phát âm ngay khi tra từ thành công
                speakHomeWord();
            } else {
                document.getElementById('res-word').innerText = word;
                document.getElementById('res-ipa').innerText = '';
                document.getElementById('res-meanings').innerHTML = `<span style="color: #dc2626;">${data.message}</span>`;
                resultBox.style.display = 'block';
            }
        } catch(e) {
            alert('Không thể kết nối tới máy chủ API từ điển. Vui lòng kiểm tra lại dịch vụ Render hoặc mạng.');
        }
    }
</script>
@endpush