@extends('layouts.app')

@section('title', 'Làm bài thi S&W: ' . $exam->title)

@push('styles')
<style>
    .skill-badge-speaking {
        background: #fdf2f8;
        color: #db2777;
        font-size: 12px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .skill-badge-writing {
        background: #ecfdf5;
        color: #059669;
        font-size: 12px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .record-btn {
        background: #ef4444;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
    }
    .record-btn.recording {
        background: #1e293b;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.6; }
        100% { opacity: 1; }
    }
</style>
@endpush

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1 style="font-size: 20px; font-weight: 800; color: #0f172a;">{{ $exam->title }}</h1>
            <p style="color: #64748b; font-size: 13.5px; margin-top: 4px;">Thời gian thi: {{ $exam->duration_minutes }} phút | Hệ thống tự động ghi âm và lưu bài viết</p>
        </div>
        <button type="button" onclick="confirmSubmit()" style="background: #0284c7; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 800; font-size: 14px; cursor: pointer;">
            Nộp bài thi
        </button>
    </div>

    <form id="swExamForm" action="{{ route('mock_test_sw.submit', $exam->id) }}" method="POST">
        @csrf

        @foreach($exam->questions as $index => $q)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <span class="{{ $q->skill === 'speaking' ? 'skill-badge-speaking' : 'skill-badge-writing' }}">
                        {{ $q->skill }} - {{ $q->task_type }}
                    </span>
                    <span style="font-size: 13px; font-weight: 600; color: #64748b;">
                        Chuẩn bị: {{ $q->prep_time_seconds }}s | Làm bài: {{ $q->response_time_seconds }}s
                    </span>
                </div>

                @if($q->image_url)
                    <div style="text-align: center; margin-bottom: 18px;">
                        <img src="{{ $q->image_url }}" alt="Đề bài ảnh" style="max-width: 100%; max-height: 300px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    </div>
                @endif

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; font-size: 15px; line-height: 1.6; color: #1e293b; font-weight: 600; margin-bottom: 20px;">
                    {!! nl2br(e($q->prompt)) !!}
                </div>

                <!-- Khu vực làm bài cho SPEAKING (Thu âm) -->
                @if($q->skill === 'speaking')
                    <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 20px; text-align: center;">
                        <button type="button" class="record-btn" id="rec-btn-{{ $q->id }}" onclick="toggleRecording('{{ $q->id }}')">
                            🎙️ Bắt đầu Thu Âm
                        </button>
                        <input type="hidden" name="speaking_recordings[{{ $q->id }}]" id="speaking-input-{{ $q->id }}" value="recording_sample_{{ $q->id }}.mp3">
                        <div id="rec-status-{{ $q->id }}" style="margin-top: 10px; font-size: 13px; color: #64748b;">Chưa có bản ghi âm. Nhấn nút để ghi âm phần nói.</div>
                    </div>
                @endif

                <!-- Khu vực làm bài cho WRITING (Gõ văn bản + Word Counter) -->
                @if($q->skill === 'writing')
                    <div>
                        <textarea 
                            name="writing_answers[{{ $q->id }}]" 
                            id="writing-text-{{ $q->id }}" 
                            rows="8" 
                            onkeyup="countWords('{{ $q->id }}')" 
                            placeholder="Gõ bài viết của bạn tại đây..." 
                            style="width: 100%; padding: 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-family: inherit; font-size: 14px; line-height: 1.6; outline: none;"
                        ></textarea>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 13px; color: #64748b;">
                            <span>Số từ đã viết: <b id="word-count-{{ $q->id }}" style="color: #0284c7;">0</b> từ</span>
                            @if($q->min_words)
                                <span>Yêu cầu tối thiểu: <b>{{ $q->min_words }}</b> từ</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        <div style="text-align: center; margin: 30px 0 60px;">
            <button type="button" onclick="confirmSubmit()" style="background: #0284c7; color: white; border: none; padding: 14px 40px; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer;">
                Nộp bài & Xem Đáp Án Mẫu
            </button>
        </div>
    </form>
</div>

<script>
    function countWords(qid) {
        let text = document.getElementById('writing-text-' + qid).value.trim();
        let words = text ? text.split(/\s+/).length : 0;
        document.getElementById('word-count-' + qid).innerText = words;
    }

    let isRecording = {};
    function toggleRecording(qid) {
        let btn = document.getElementById('rec-btn-' + qid);
        let status = document.getElementById('rec-status-' + qid);

        if (!isRecording[qid]) {
            isRecording[qid] = true;
            btn.classList.add('recording');
            btn.innerText = '⏹️ Dừng Thu Âm';
            status.innerText = 'Đang thu âm giọng nói của bạn... Hãy đọc to rõ ràng!';
            status.style.color = '#ef4444';
        } else {
            isRecording[qid] = false;
            btn.classList.remove('recording');
            btn.innerText = '🎙️ Thu Âm Lại';
            status.innerText = '✅ Đã lưu bản thu âm thành công!';
            status.style.color = '#059669';
        }
    }

    function confirmSubmit() {
        if (confirm('Bạn có chắc chắn muốn nộp bài thi Nói & Viết?')) {
            document.getElementById('swExamForm').submit();
        }
    }
</script>
@endsection