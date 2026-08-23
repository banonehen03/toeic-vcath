@extends('layouts.app')

@section('title', 'Chấm Điểm Thi Thử S&W - ' . $result->user->name)

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: #0284c7; text-decoration: none; margin-bottom: 16px;">
        &larr; Quay lại Dashboard Quản Trị
    </a>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <span style="background: #e0f2fe; color: #0284c7; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
            Đang chấm bài thi S&W
        </span>
        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 8px 0 4px;">{{ $result->exam->title }}</h1>
        <p style="font-size: 13.5px; color: #64748b;">Học viên: <b>{{ $result->user->name }}</b> ({{ $result->user->email }}) | Ngày nộp: {{ $result->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Form Chấm Điểm -->
    <form action="{{ route('admin.save_grade_sw', $result->id) }}" method="POST">
        @csrf

        <div style="background: #ffffff; border: 2px solid #0284c7; border-radius: 16px; padding: 24px; margin-bottom: 28px; box-shadow: 0 4px 10px rgba(2,132,199,0.08);">
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Điểm Số & Nhận Xét Của Giảng Viên</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Điểm Speaking (Thang 200):</label>
                    <input type="number" name="speaking_score" min="0" max="200" value="{{ $result->speaking_score ?? 0 }}" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; font-weight: 700; color: #db2777; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Điểm Writing (Thang 200):</label>
                    <input type="number" name="writing_score" min="0" max="200" value="{{ $result->writing_score ?? 0 }}" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; font-weight: 700; color: #059669; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Lời nhận xét & Góp ý cho học viên:</label>
                <textarea name="teacher_feedback" rows="4" placeholder="Nhận xét chi tiết phát âm, từ vựng, cấu trúc câu..." style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; line-height: 1.5; outline: none;">{{ $result->teacher_feedback }}</textarea>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background: #0284c7; color: white; border: none; padding: 11px 32px; border-radius: 8px; font-size: 14.5px; font-weight: 800; cursor: pointer;">
                    Lưu Điểm & Hoàn Tất Chấm Bài
                </button>
            </div>
        </div>

        <!-- Chi tiết bài làm -->
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Chi Tiết Nội Dung Bài Làm</h2>

        @foreach($result->exam->questions as $q)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-weight: 800; font-size: 15px; color: #0284c7;">{{ $q->task_type }}</span>
                    <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">{{ $q->skill }}</span>
                </div>

                @if($q->image_url)
                    <div style="text-align: center; margin-bottom: 14px;">
                        <img src="{{ $q->image_url }}" alt="Hình ảnh đề bài" style="max-width: 100%; max-height: 240px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                @endif

                <div style="background: #f8fafc; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #1e293b; margin-bottom: 16px; line-height: 1.6;">
                    <b>Đề bài:</b> {!! nl2br(e($q->prompt)) !!}
                </div>

                @if($q->skill === 'writing')
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">Bài viết của học viên:</div>
                        <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 14px; font-size: 14px; line-height: 1.6; color: #1e293b;">
                            {!! nl2br(e($result->writing_answers[$q->id] ?? 'Học viên không nhập nội dung.')) !!}
                        </div>
                    </div>
                @else
                    <div style="margin-bottom: 14px; background: #fdf2f8; border: 1px solid #fbcfe8; border-radius: 8px; padding: 14px; font-size: 13.5px; color: #9d174d;">
                        🎧 <b>File ghi âm:</b> <code>{{ $result->speaking_recordings[$q->id] ?? 'Chưa ghi âm' }}</code>
                    </div>
                @endif

                @if($q->sample_answer)
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #166534; line-height: 1.5;">
                        <b>Đáp án mẫu tham khảo:</b> {!! nl2br(e($q->sample_answer)) !!}
                    </div>
                @endif
            </div>
        @endforeach
    </form>
</div>
@endsection