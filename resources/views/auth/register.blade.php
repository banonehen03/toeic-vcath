@extends('layouts.auth')

@section('title', 'Đăng ký tài khoản - TOEIC VCATH')
@section('heading', 'Tạo Tài Khoản Mới')
@section('subheading', 'Điền đầy đủ thông tin để nhận mã xác thực')

@section('content')
    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ví dụ: Nguyễn Văn A">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="form-group">
                <label>Tên tài khoản</label>
                <input type="text" name="username" value="{{ old('username') }}" required placeholder="nguyenvana">
            </div>
            <div class="form-group">
                <label>Số CCCD/CMND</label>
                <input type="text" name="citizen_id" value="{{ old('citizen_id') }}" required placeholder="00120300xxxx">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="form-group">
                <label>Email xác minh</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@gmail.com">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="0987654321">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required placeholder="••••••">
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" required placeholder="••••••">
            </div>
        </div>

        <button type="submit" class="btn-auth" style="margin-top: 10px;">Đăng ký & Nhận mã OTP</button>
    </form>

    <div style="margin-top: 18px; text-align: center; font-size: 13px; color: #64748b;">
        Đã có tài khoản? <a href="{{ route('login') }}" style="color: #0284c7; font-weight: 700; text-decoration: none;">Đăng nhập ngay</a>
    </div>
@endsection