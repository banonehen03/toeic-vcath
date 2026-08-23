@extends('layouts.auth')

@section('title', 'Đăng nhập tài khoản')
@section('heading', 'Đăng Nhập')
@section('subheading', 'Truy cập nền tảng học & luyện thi TOEIC VCATH')

@section('content')
    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Email tài khoản</label>
            <input type="email" name="email" required placeholder="admin@gmail.com">
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <label style="margin-bottom: 0;">Mật khẩu</label>
                <a href="{{ route('password.request') }}" style="font-size: 12px; color: #0284c7; text-decoration: none; font-weight: 600;">Quên mật khẩu?</a>
            </div>
            <input type="password" name="password" required placeholder="••••••">
        </div>

        <button type="submit" class="btn-auth">Đăng nhập</button>
    </form>

    <div style="margin-top: 18px; text-align: center; font-size: 13px; color: #64748b;">
        Chưa có tài khoản? <a href="{{ route('register') }}" style="color: #059669; font-weight: 700; text-decoration: none;">Đăng ký ngay</a>
    </div>

    <div class="hint-box">
        <b style="color: #0f172a;">Tài khoản kiểm thử (Pass: 123456):</b><br>
        • <b>Admin:</b> admin@gmail.com<br>
        • <b>Giảng viên:</b> teacher@gmail.com<br>
        • <b>Học viên:</b> student@gmail.com
    </div>
@endsection