@extends('layouts.app')

@section('title', 'Đang Thi Đấu - TOEIC Arena')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <!-- Thanh trạng thái: Câu hỏi & Đồng hồ bấm giờ -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px 22px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <span id="arenaCounter" style="font-size: 14px; font-weight: 800; color: #4f46e5;">Câu 1 / {{ $questions->count() }}</span>
        <div style="display: flex; align-items: center; gap: 6px; font-size: 16px; font-weight: 800; color: #e11d48;">
            ⏱️ <span id="timerBox">00:00</span>
        </div>
    </div>

    <!-- Hộp hiển thị câu hỏi -->
    <div id="questionWrapper" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); margin-bottom: 20px;">
        <h2 id="qText" style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 20px; line-height: 1.5;">...</h2>

        <div id="optionsContainer" style="display: grid; grid-template-columns: 1fr; gap: 10px;">
            <!-- Options rendered via JS -->
        </div>
    </div>
</div>

<div id="arenaDataHolder" data-questions="{{ json_encode($questions) }}" style="display: none;"></div>

<script>
    const questions = JSON.parse(document.getElementById('arenaDataHolder').getAttribute('data-questions') || '[]');
    let currentIndex = 0;
    let userAnswers = {};
    let secondsElapsed = 0;
    let timerInterval = null;

    function startTimer() {
        timerInterval = setInterval(() => {
            secondsElapsed++;
            let m = Math.floor(secondsElapsed / 60).toString().padStart(2, '0');
            let s = (secondsElapsed % 60).toString().padStart(2, '0');
            document.getElementById('timerBox').innerText = `${m}:${s}`;
        }, 1000);
    }

    function renderCurrentQuestion() {
        if (currentIndex >= questions.length) {
            finishMatch();
            return;
        }

        const q = questions[currentIndex];
        document.getElementById('arenaCounter').innerText = `Câu ${currentIndex + 1} / ${questions.length}`;
        document.getElementById('qText').innerText = q.question || q.question_text;

        const container = document.getElementById('optionsContainer');
        container.innerHTML = '';

        const opts = [
            { key: 'A', text: q.option_a },
            { key: 'B', text: q.option_b },
            { key: 'C', text: q.option_c },
            { key: 'D', text: q.option_d }
        ];

        opts.forEach(opt => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.style = 'text-align: left; padding: 14px 18px; border: 1.5px solid #e2e8f0; border-radius: 10px; background: #ffffff; font-size: 14px; font-weight: 600; color: #1e293b; cursor: pointer; transition: all 0.15s ease;';
            btn.innerHTML = `<b>(${opt.key})</b> ${opt.text}`;
            btn.onclick = () => selectOption(q.id, opt.key);
            btn.onmouseover = () => btn.style.borderColor = '#4f46e5';
            btn.onmouseout = () => btn.style.borderColor = '#e2e8f0';
            container.appendChild(btn);
        });
    }

    function selectOption(qId, selectedKey) {
        userAnswers[qId] = selectedKey;
        currentIndex++;
        renderCurrentQuestion();
    }

    function finishMatch() {
        clearInterval(timerInterval);
        document.getElementById('questionWrapper').innerHTML = `
            <div style="text-align: center; padding: 30px 10px;">
                <div style="font-size: 36px; margin-bottom: 10px;">⏳</div>
                <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Đang nộp bài và tính điểm...</h2>
            </div>
        `;

        fetch("{{ route('arena.submit') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answers: userAnswers,
                questions_payload: questions,
                time_spent: secondsElapsed
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(`Trận đấu kết thúc!\nKết quả: ${data.score}/${data.total} đúng trong ${data.time_spent} giây.`);
                window.location.href = data.redirect_url;
            }
        });
    }

    startTimer();
    renderCurrentQuestion();
</script>
@endsection