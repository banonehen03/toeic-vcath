@extends('layouts.app')

@section('title', $topic->title . ' - Cộng Đồng TOEIC VCATH')

@push('styles')
<style>
    .btn-like-topic {
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-like-topic.liked {
        background: #fee2e2;
        color: #ef4444;
        border-color: #fecaca;
    }
    .btn-like-topic.unliked {
        background: #f8fafc;
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    <a href="{{ route('community.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại danh sách thảo luận
    </a>

    <!-- Bài viết chính -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; margin-bottom: 26px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 6px;">
                {{ $topic->tag }}
            </span>
            <span style="font-size: 12.5px; color: #94a3b8;">{{ $topic->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 8px; line-height: 1.35;">{{ $topic->title }}</h1>
        <div style="font-size: 13px; color: #64748b; margin-bottom: 18px;">
            Tác giả: <b>{{ $topic->user->name ?? 'Người dùng' }}</b>
        </div>

        <div style="font-size: 14.5px; line-height: 1.7; color: #1e293b; margin-bottom: 20px; white-space: pre-line;">{{ $topic->content }}</div>

        <div style="border-top: 1px solid #f1f5f9; padding-top: 14px; display: flex; align-items: center; gap: 12px;">
            @auth
                <button type="button" id="likeBtn" data-topic-id="{{ $topic->id }}" class="btn-like-topic {{ $topic->isLikedBy(Auth::user()) ? 'liked' : 'unliked' }}">
                    ❤️ <span id="likeCount">{{ $topic->likes_count }}</span> Thích
                </button>
            @else
                <span style="font-size: 13px; color: #64748b;">❤️ <b>{{ $topic->likes_count }}</b> lượt thích</span>
            @endauth
        </div>
    </div>

    <!-- Danh sách Bình luận -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 18px;">💬 Phản hồi & Bình luận ({{ $topic->comments->count() }})</h2>

        @auth
            <form action="{{ route('community.comment', $topic->id) }}" method="POST" style="margin-bottom: 24px;">
                @csrf
                <textarea name="content" rows="3" required placeholder="Viết câu trả lời hoặc góp ý của bạn..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 13.5px; outline: none; margin-bottom: 10px;"></textarea>
                <div style="text-align: right;">
                    <button type="submit" style="background: #0284c7; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer;">
                        Gửi bình luận
                    </button>
                </div>
            </form>
        @else
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; text-align: center; font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
                Vui lòng <a href="{{ route('login') }}" style="color: #0284c7; font-weight: 700;">đăng nhập</a> để tham gia thảo luận.
            </div>
        @endauth

        <div style="display: flex; flex-direction: column; gap: 14px;">
            @forelse($topic->comments as $cm)
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-weight: 700; font-size: 13.5px; color: #1e293b;">{{ $cm->user->name ?? 'Người dùng' }}</span>
                        <span style="font-size: 12px; color: #94a3b8;">{{ $cm->created_at->diffForHumans() }}</span>
                    </div>
                    <div style="font-size: 13.5px; color: #334155; line-height: 1.5; white-space: pre-line;">{{ $cm->content }}</div>
                </div>
            @empty
                <p style="color: #94a3b8; font-size: 13.5px;">Chưa có bình luận nào. Hãy là người đầu tiên giải đáp thắc mắc này!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const likeBtn = document.getElementById('likeBtn');
        if (likeBtn) {
            likeBtn.addEventListener('click', function () {
                const topicId = this.getAttribute('data-topic-id');
                const csrfMeta = document.querySelector('input[name="_token"]');
                const token = csrfMeta ? csrfMeta.value : '{{ csrf_token() }}';

                fetch(`/community/${topicId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('likeCount').innerText = data.likes_count;
                        if (data.liked) {
                            likeBtn.classList.remove('unliked');
                            likeBtn.classList.add('liked');
                        } else {
                            likeBtn.classList.remove('liked');
                            likeBtn.classList.add('unliked');
                        }
                    }
                });
            });
        }
    });
</script>
@endpush