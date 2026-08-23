@extends('layouts.app')

@section('title', 'Bảng Vinh Danh TOEIC 800+ - TOEIC VCATH')

@push('styles')
<style>
    .fame-banner {
        background: linear-gradient(135deg, #1e1b4b, #312e81);
        border-radius: 18px;
        padding: 36px;
        color: white;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(30, 27, 75, 0.25);
    }
    .fame-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
    }
    .fame-card.gold { border: 2px solid #f59e0b; }
    .fame-card.blue { border: 2px solid #38bdf8; }

    .fame-badge {
        position: absolute;
        top: 12px;
        right: -30px;
        background: #f59e0b;
        color: white;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 30px;
        transform: rotate(45deg);
        text-transform: uppercase;
    }

    .fame-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        margin: 0 auto 12px;
    }
    .fame-avatar.gold { background: #fef3c7; color: #d97706; }
    .fame-avatar.blue { background: #e0f2fe; color: #0284c7; }

    .score-text-gold { color: #d97706; }
    .score-text-blue { color: #0284c7; }
</style>
@endpush

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <!-- Banner Vinh Danh -->
    <div class="fame-banner">
        <div style="font-size: 40px; margin-bottom: 8px;">👑</div>
        <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 6px;">Bảng Vinh Danh TOEIC Cao Thủ (Hall of Fame)</h1>
        <p style="color: #c7d2fe; font-size: 14.5px; max-width: 500px; margin: 0 auto;">Vinh danh những học viên xuất sắc chinh phục band điểm TOEIC 800+ và 900+ trên hệ thống TOEIC VCATH.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
        @forelse($highAchievers as $h)
            <div class="fame-card {{ $h->best_score >= 900 ? 'gold' : 'blue' }}">
                @if($h->best_score >= 900)
                    <div class="fame-badge">
                        Xuất sắc
                    </div>
                @endif

                <div class="fame-avatar {{ $h->best_score >= 900 ? 'gold' : 'blue' }}">
                    {{ strtoupper(substr($h->user->name ?? 'U', 0, 1)) }}
                </div>

                <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $h->user->name ?? 'Học viên ẩn danh' }}</h3>
                <div class="fame-score {{ $h->best_score >= 900 ? 'score-text-gold' : 'score-text-blue' }}" style="font-size: 26px; font-weight: 800; margin-bottom: 6px;">
                    {{ $h->best_score }} <span style="font-size: 14px; color: #64748b; font-weight: 600;">/990</span>
                </div>
                <div style="font-size: 12px; color: #94a3b8;">Đạt mốc: {{ \Carbon\Carbon::parse($h->achieved_at)->format('d/m/Y') }}</div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; color: #94a3b8;">
                Chưa có học viên nào đạt mốc điểm 800+. Hãy là người đầu tiên ghi tên vào Bảng vinh danh!
            </div>
        @endforelse
    </div>
</div>
@endsection