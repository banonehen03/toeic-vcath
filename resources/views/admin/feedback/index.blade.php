@extends('layouts.app')

@section('title', 'Quản Lý Phản Hồi & Báo Lỗi - Admin')

@push('styles')
<style>
    .badge-feedback {
        font-size: 12px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
    }
    .badge-bug {
        background: #fee2e2;
        color: #b91c1c;
    }
    .badge-general {
        background: #e0f2fe;
        color: #0284c7;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1040px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">📬 Hòm Thư Góp Ý & Báo Lỗi</h1>
            <p style="color: #64748b; font-size: 14px;">Tiếp nhận và xử lý các báo cáo về nội dung, lỗi hệ thống từ người dùng.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" style="background: #f1f5f9; color: #475569; padding: 9px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">&larr; Dashboard</a>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 16px;">
        @forelse($feedbacks as $fb)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="badge-feedback {{ $fb->type === 'Báo lỗi đề thi' ? 'badge-bug' : 'badge-general' }}">
                            {{ $fb->type }}
                        </span>
                        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">{{ $fb->title }}</h3>
                    </div>
                    <span style="font-size: 12px; color: #94a3b8;">{{ $fb->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <p style="font-size: 13.5px; color: #334155; line-height: 1.6; margin-bottom: 12px;">{!! nl2br(e($fb->content)) !!}</p>

                <div style="font-size: 12.5px; color: #64748b; margin-bottom: 14px;">
                    Người gửi: <b>{{ $fb->name ?? ($fb->user->name ?? 'Khách') }}</b> ({{ $fb->email ?? ($fb->user->email ?? 'N/A') }})
                </div>

                <form action="{{ route('admin.feedback.update', $fb->id) }}" method="POST" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    @csrf
                    @method('PUT')

                    <select name="status" style="padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: 700; background: white;">
                        <option value="pending" {{ $fb->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="resolved" {{ $fb->status === 'resolved' ? 'selected' : '' }}>Đã xử lý</option>
                    </select>

                    <input type="text" name="admin_note" value="{{ $fb->admin_note }}" placeholder="Ghi chú giải quyết của Admin..." style="flex: 1; min-width: 200px; padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; outline: none;">

                    <button type="submit" style="background: #0284c7; color: white; border: none; padding: 6px 14px; border-radius: 6px; font-size: 12.5px; font-weight: 700; cursor: pointer;">
                        Cập nhật
                    </button>
                </form>
            </div>
        @empty
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 30px; text-align: center; color: #94a3b8;">
                Chưa có góp ý hoặc báo lỗi nào.
            </div>
        @endforelse
    </div>

    <div style="margin-top: 20px;">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection