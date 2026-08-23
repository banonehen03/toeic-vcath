@extends('layouts.app')

@section('title', 'Cộng Đồng Thảo Luận - TOEIC VCATH')

@push('styles')
<style>
    .comm-tag-btn {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        background: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .comm-tag-btn:hover { background: #f8fafc; color: #0f172a; }
    .comm-tag-btn.active { background: #0284c7; color: #ffffff; border-color: #0284c7; }
</style>
@endpush

@section('content')
<div style="max-width: 960px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">💬 Cộng Đồng Học Tập & Thảo Luận</h1>
            <p style="color: #64748b; font-size: 14px;">Chia sẻ câu hỏi khó, trao đổi kinh nghiệm luyện thi TOEIC cùng các học viên khác.</p>
        </div>
        @auth
            <a href="#newPostForm" style="background: #0284c7; color: white; padding: 9px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">
                + Đăng bài thảo luận
            </a>
        @endauth
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bộ lọc Tag -->
    <div style="display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap;">
        <a href="{{ route('community.index') }}" class="comm-tag-btn {{ empty($tag) ? 'active' : '' }}">Tất cả</a>
        @foreach($tags as $t)
            <a href="{{ route('community.index', ['tag' => $t]) }}" class="comm-tag-btn {{ $tag === $t ? 'active' : '' }}">{{ $t }}</a>
        @endforeach
    </div>

    <!-- Form đăng bài nhanh (nếu đã đăng nhập) -->
    @auth
        <div id="newPostForm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; margin-bottom: 26px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 14px;">Tạo Bài Thảo Luận Mới</h2>
            <form action="{{ route('community.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px; margin-bottom: 12px;">
                    <input type="text" name="title" required placeholder="Tiêu đề câu hỏi / thắc mắc..." style="padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                    <select name="tag" required style="padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: white;">
                        @foreach($tags as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <textarea name="content" rows="3" required placeholder="Mô tả chi tiết câu hỏi hoặc paste nội dung bài tập cần giải đáp..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none;"></textarea>
                </div>
                <div style="text-align: right;">
                    <button type="submit" style="background: #0284c7; color: white; border: none; padding: 9px 22px; border-radius: 8px; font-size: 13.5px; font-weight: 700; cursor: pointer;">
                        Đăng bài
                    </button>
                </div>
            </form>
        </div>
    @endauth

    <!-- Danh sách Topics -->
    <div style="display: flex; flex-direction: column; gap: 14px;">
        @forelse($topics as $tp)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div style="flex: 1; min-width: 280px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                        <span style="background: #e0f2fe; color: #0284c7; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">{{ $tp->tag }}</span>
                        <span style="font-size: 12.5px; color: #64748b;">Đăng bởi <b>{{ $tp->user->name ?? 'Người dùng' }}</b> &bull; {{ $tp->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('community.show', $tp->id) }}" style="font-size: 16px; font-weight: 800; color: #0f172a; text-decoration: none; line-height: 1.4;">
                        {{ $tp->title }}
                    </a>
                </div>

                <div style="display: flex; align-items: center; gap: 16px; font-size: 13px; color: #64748b;">
                    <span>❤️ <b>{{ $tp->likes_count }}</b></span>
                    <span>💬 <b>{{ $tp->comments_count }}</b> trả lời</span>
                    <a href="{{ route('community.show', $tp->id) }}" style="background: #f1f5f9; color: #0284c7; padding: 6px 12px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 12.5px;">
                        Xem &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 30px; text-align: center; color: #94a3b8;">
                Chưa có chủ đề thảo luận nào. Hãy là người đầu tiên đặt câu hỏi!
            </div>
        @endforelse
    </div>

    <div style="margin-top: 20px;">
        {{ $topics->links() }}
    </div>
</div>
@endsection