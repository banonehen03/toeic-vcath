@extends('layouts.app')

@section('title', 'Đấu Trường TOEIC - Arena Speed Challenge')

@push('styles')
<style>
    .arena-banner {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        border-radius: 18px;
        padding: 36px;
        color: white;
        text-align: center;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
        margin-bottom: 30px;
    }
    .rank-badge-1 { background: #fef08a; color: #854d0e; font-weight: 800; }
    .rank-badge-2 { background: #e2e8f0; color: #334155; font-weight: 800; }
    .rank-badge-3 { background: #fed7aa; color: #9a3412; font-weight: 800; }
</style>
@endpush

@section('content')
<div style="max-width: 880px; margin: 0 auto;">
    <div class="arena-banner">
        <div style="font-size: 38px; margin-bottom: 8px;">⚡</div>
        <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 8px;">Đấu Trường Tốc Độ (TOEIC Arena)</h1>
        <p style="font-size: 14.5px; color: #e0e7ff; max-width: 520px; margin: 0 auto 20px; line-height: 1.5;">
            Thử thách 10 câu trắc nghiệm tốc độ ngẫu nhiên. Trả lời đúng nhiều nhất trong thời gian ngắn nhất để leo top bảng xếp hạng.
        </p>

        @auth
            <a href="{{ route('arena.play') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #4f46e5; padding: 12px 32px; border-radius: 10px; font-size: 15px; font-weight: 800; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                Vào Đấu Ngay &rarr;
            </a>
        @else
            <a href="javascript:void(0)" onclick="openAuthModal('Đấu trường')" style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #4f46e5; padding: 12px 32px; border-radius: 10px; font-size: 15px; font-weight: 800; text-decoration: none;">
                Đăng nhập để tham gia &rarr;
            </a>
        @endauth
    </div>

    @if($myBest)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 24px; margin-bottom: 26px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kỷ lục cá nhân của bạn</span>
                <div style="font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $myBest->score }}/10 Đúng</div>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Thời gian</span>
                <div style="font-size: 18px; font-weight: 800; color: #0284c7; margin-top: 2px;">{{ $myBest->time_spent_seconds }} giây</div>
            </div>
        </div>
    @endif

    <!-- Bảng xếp hạng Top 10 -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">🏆 Bảng Xếp Hạng Đấu Thủ Xuất Sắc</h2>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left; color: #64748b;">
                        <th style="padding: 10px 12px; width: 80px;">Hạng</th>
                        <th style="padding: 10px 12px;">Đấu thủ</th>
                        <th style="padding: 10px 12px;">Điểm số</th>
                        <th style="padding: 10px 12px;">Thời gian</th>
                        <th style="padding: 10px 12px; text-align: right;">Thời điểm</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPlayers as $index => $p)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 14px 12px;">
                                <span style="display: inline-block; width: 28px; height: 28px; line-height: 28px; text-align: center; border-radius: 50%;" class="{{ $index == 0 ? 'rank-badge-1' : ($index == 1 ? 'rank-badge-2' : ($index == 2 ? 'rank-badge-3' : '')) }}">
                                    #{{ $index + 1 }}
                                </span>
                            </td>
                            <td style="padding: 14px 12px; font-weight: 700; color: #1e293b;">
                                {{ $p->user->name }}
                            </td>
                            <td style="padding: 14px 12px; font-weight: 800; color: #059669;">
                                {{ $p->score }}/10 Đúng
                            </td>
                            <td style="padding: 14px 12px; color: #4f46e5; font-weight: 700;">
                                {{ $p->time_spent_seconds }}s
                            </td>
                            <td style="padding: 14px 12px; text-align: right; color: #64748b;">
                                {{ $p->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 24px; text-align: center; color: #94a3b8;">Chưa có đấu thủ nào hoàn thành trận đấu. Hãy là người đầu tiên!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection