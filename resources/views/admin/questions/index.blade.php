@extends('layouts.app')

@section('title', 'Ngân Hàng Câu Hỏi - Admin TOEIC VCATH')

@section('content')
<div style="max-width: 1040px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">❓ Ngân Hàng Câu Hỏi Trắc Nghiệm</h1>
            <p style="color: #64748b; font-size: 14px;">Quản lý và tra cứu ngân hàng câu hỏi trắc nghiệm của các bài học.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dashboard') }}" style="background: #f1f5f9; color: #475569; padding: 9px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">&larr; Dashboard</a>
            <a href="{{ route('admin.questions.create') }}" style="background: #0284c7; color: white; padding: 9px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 13.5px;">+ Thêm câu hỏi</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bộ lọc bài học -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 20px;">
        <form action="{{ route('admin.questions.index') }}" method="GET" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <label style="font-size: 13.5px; font-weight: 700; color: #334155;">Lọc theo bài học:</label>
            <select name="lesson_id" onchange="this.form.submit()" style="flex: 1; max-width: 400px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; outline: none; background: white;">
                <option value="">-- Tất cả bài học --</option>
                @foreach($lessons as $l)
                    <option value="{{ $l->id }}" {{ $lessonId == $l->id ? 'selected' : '' }}>
                        {{ $l->title }}
                    </option>
                @endforeach
            </select>
            @if($lessonId)
                <a href="{{ route('admin.questions.index') }}" style="color: #64748b; font-size: 13px; text-decoration: none; font-weight: 600;">Xóa bộ lọc</a>
            @endif
        </form>
    </div>

    <!-- Danh sách câu hỏi -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left; color: #64748b;">
                        <th style="padding: 10px 12px; width: 40%;">Nội dung câu hỏi</th>
                        <th style="padding: 10px 12px;">Thuộc bài học</th>
                        <th style="padding: 10px 12px; text-align: center;">Đáp án đúng</th>
                        <th style="padding: 10px 12px; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 14px 12px; color: #1e293b; font-weight: 600; line-height: 1.5;">
                                {{ $q->question_text }}
                                <div style="font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 400;">
                                    A: {{ $q->option_a }} | B: {{ $q->option_b }} | C: {{ $q->option_c }} | D: {{ $q->option_d }}
                                </div>
                            </td>
                            <td style="padding: 14px 12px; color: #0284c7; font-weight: 600;">
                                {{ $q->lesson->title ?? 'N/A' }}
                            </td>
                            <td style="padding: 14px 12px; text-align: center;">
                                <span style="background: #dcfce7; color: #166534; font-weight: 800; padding: 3px 10px; border-radius: 12px;">
                                    {{ $q->correct_option }}
                                </span>
                            </td>
                            <td style="padding: 14px 12px; text-align: right;">
                                <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #fee2e2; color: #b91c1c; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 12px; cursor: pointer;">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 24px; text-align: center; color: #94a3b8;">Không tìm thấy câu hỏi nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $questions->appends(['lesson_id' => $lessonId])->links() }}
        </div>
    </div>
</div>
@endsection