@extends('layouts.app')

@section('title', 'Bảng Xếp Hạng - TOEIC VCATH')

@push('styles')
<style>
    .rank-num { width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; }
    .rank-1 { background: #fef08a; color: #854d0e; }
    .rank-2 { background: #e2e8f0; color: #334155; }
    .rank-3 { background: #fed7aa; color: #9a3412; }
    .rank-default { background: #f8fafc; color: #64748b; }
</style>
@endpush

@section('content')
<div style="max-width: 1040px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="font-size: 36px; margin-bottom: 6px;">🎖️</div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a;">Bảng Xếp Hạng Thành Tích Học Tập</h1>
        <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Tôn vinh những học viên có thành tích xuất sắc và nỗ lực bền bỉ nhất trên TOEIC VCATH.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 24px;">
        <!-- Cột 1: Top Thi thử L&R -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <span style="font-size: 20px;">🏆</span>
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a;">Top Điểm Thi Thử L&R</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tbody>
                        @forelse($topMockTests as $i => $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px 4px; width: 40px;">
                                    <span class="rank-num {{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : 'rank-default')) }}">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td style="padding: 10px 8px; font-weight: 700; color: #1e293b;">
                                    {{ $item->user->name ?? 'Học viên ẩn danh' }}
                                </td>
                                <td style="padding: 10px 4px; text-align: right; font-weight: 800; color: #059669;">
                                    {{ $item->best_score }}/990
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; padding: 20px; color: #94a3b8;">Chưa có lượt thi thử.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cột 2: Top Đấu trường Arena -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <span style="font-size: 20px;">⚡</span>
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a;">Cao Thủ Đấu Trường</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tbody>
                        @forelse($topArena as $i => $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px 4px; width: 40px;">
                                    <span class="rank-num {{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : 'rank-default')) }}">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td style="padding: 10px 8px; font-weight: 700; color: #1e293b;">
                                    {{ $item->user->name ?? 'Học viên ẩn danh' }}
                                </td>
                                <td style="padding: 10px 4px; text-align: right;">
                                    <span style="font-weight: 800; color: #4f46e5;">{{ $item->max_score }}/10</span>
                                    <span style="font-size: 11px; color: #94a3b8;">({{ $item->min_time }}s)</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; padding: 20px; color: #94a3b8;">Chưa có trận đấu nào.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cột 3: Top Chăm chỉ Từ vựng -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <span style="font-size: 20px;">📚</span>
                <h2 style="font-size: 16px; font-weight: 800; color: #0f172a;">Kiện Tướng Từ Vựng</h2>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tbody>
                        @forelse($topVocab as $i => $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px 4px; width: 40px;">
                                    <span class="rank-num {{ $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : 'rank-default')) }}">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td style="padding: 10px 8px; font-weight: 700; color: #1e293b;">
                                    {{ $item->user->name ?? 'Học viên ẩn danh' }}
                                </td>
                                <td style="padding: 10px 4px; text-align: right; font-weight: 800; color: #0284c7;">
                                    {{ $item->total_memorized }} từ
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; padding: 20px; color: #94a3b8;">Chưa có dữ liệu từ vựng.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection