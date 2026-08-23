@extends('layouts.app')

@section('title', 'Luyện viết: ' . $task->title)

@section('content')
<div style="max-width: 840px; margin: 0 auto;">
    <a href="{{ route('writing_practice.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách bài viết
    </a>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); margin-bottom: 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
            <span style="background: #ecfdf5; color: #059669; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                {{ str_replace('_', ' ', $task->part) }}
            </span>
            <span style="color: #64748b; font-size: 13px; font-weight: 600;">Thời gian gợi ý: {{ $task->time_limit_minutes }} phút</span>
        </div>

        <h1 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">{{ $task->title }}</h1>

        @if($task->image_url)
            <div style="text-align: center; margin-bottom: 18px;">
                <img src="{{ $task->image_url }}" alt="Hình ảnh đề bài" style="max-width: 100%; max-height: 320px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>
        @endif

        @if($task->keywords)
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 10px 16px; font-size: 14px; color: #1e40af; margin-bottom: 16px;">
                <b>Từ khóa bắt buộc:</b> <span style="font-weight: 700;">{{ $task->keywords }}</span>
            </div>
        @endif

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; font-size: 14.5px; line-height: 1.7; color: #1e293b;">
            {!! nl2br(e($task->prompt)) !!}
        </div>
    </div>

    <!-- Form làm bài viết -->
    @auth
        <form action="{{ route('writing_practice.submit', $task->id) }}" method="POST" style="margin-bottom: 30px;">
            @csrf
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <label style="font-size: 14px; font-weight: 700; color: #334155;">Bài viết của bạn:</label>
                    <span style="font-size: 13px; color: #64748b;">Số từ: <b id="wordCountLive" style="color: #0284c7;">{{ $previousSubmission ? $previousSubmission->word_count : 0 }}</b> từ</span>
                </div>

                <textarea 
                    name="content" 
                    id="writingInput" 
                    rows="10" 
                    onkeyup="updateWordCount()" 
                    placeholder="Bắt đầu nhập nội dung bài viết của bạn..." 
                    style="width: 100%; padding: 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-family: inherit; font-size: 14.5px; line-height: 1.6; outline: none; margin-bottom: 16px;"
                >{{ $previousSubmission ? $previousSubmission->content : '' }}</textarea>

                <div style="text-align: right;">
                    <button type="submit" style="background: #0284c7; color: white; border: none; padding: 11px 28px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer;">
                        {{ $previousSubmission ? 'Lưu lại bài viết' : 'Nộp bài viết' }}
                    </button>
                </div>
            </div>
        </form>
    @else
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; text-align: center; margin-bottom: 30px;">
            <p style="color: #64748b; font-size: 14px; margin-bottom: 12px;">Vui lòng đăng nhập để bắt đầu gõ và nộp bài viết.</p>
            <button type="button" onclick="openAuthModal('Luyện Viết TOEIC')" style="background: #0284c7; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                Đăng nhập ngay
            </button>
        </div>
    @endauth

    <!-- Bài viết mẫu & Từ vựng gợi ý -->
    @if($task->sample_response || $task->key_vocabulary)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; margin-bottom: 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            @if($task->key_vocabulary)
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 15px; font-weight: 800; color: #0284c7; margin-bottom: 8px;">📚 Từ Vựng & Cụm Từ Trọng Điểm:</h3>
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 12px 16px; font-size: 13.5px; color: #0369a1; line-height: 1.6;">
                        {{ $task->key_vocabulary }}
                    </div>
                </div>
            @endif

            @if($task->sample_response)
                <div>
                    <h3 style="font-size: 15px; font-weight: 800; color: #059669; margin-bottom: 8px;">💡 Bài Viết Mẫu Tham Khảo (Sample Band Điểm Cao):</h3>
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; font-size: 14px; line-height: 1.7; color: #166534;">
                        {!! nl2br(e($task->sample_response)) !!}
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

<script>
    function updateWordCount() {
        let text = document.getElementById('writingInput').value.trim();
        let words = text ? text.split(/\s+/).length : 0;
        document.getElementById('wordCountLive').innerText = words;
    }
</script>
@endsection