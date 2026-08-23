@extends('layouts.app')

@section('title', 'Góp Ý & Báo Lỗi - TOEIC VCATH')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">💡 Góp Ý & Báo Lỗi Hệ Thống</h1>
        <p style="color: #64748b; font-size: 14px;">Bạn phát hiện lỗi trong câu hỏi, đề thi hoặc muốn đề xuất thêm tính năng mới? Hãy chia sẻ với đội ngũ phát triển.</p>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf

            @guest
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Họ và tên (*)</label>
                        <input type="text" name="name" required placeholder="Nguyễn Văn A" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Email liên hệ (*)</label>
                        <input type="email" name="email" required placeholder="email@example.com" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                    </div>
                </div>
            @endguest

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Loại phản hồi (*)</label>
                    <select name="type" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: white;">
                        <option value="Báo lỗi đề thi">Báo lỗi đề thi / Câu hỏi</option>
                        <option value="Góp ý tính năng">Góp ý tính năng mới</option>
                        <option value="Lỗi kỹ thuật">Lỗi kỹ thuật / Audio</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Tiêu đề tóm tắt (*)</label>
                    <input type="text" name="title" required placeholder="ví dụ: Audio Part 1 câu số 3 không nghe được..." style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Chi tiết phản hồi / Mô tả lỗi (*)</label>
                <textarea name="content" rows="6" required placeholder="Mô tả chi tiết nội dung cần phản hồi hoặc các bước gặp lỗi..." style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; line-height: 1.6; outline: none;"></textarea>
            </div>

            <button type="submit" style="width: 100%; background: #0284c7; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer;">
                Gửi Phản Hồi
            </button>
        </form>
    </div>
</div>
@endsection