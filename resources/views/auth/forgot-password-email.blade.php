@extends('layouts.auth')

@section('title', 'Quên mật khẩu - TOEIC VCATH')
@section('heading', 'Khôi Phục Mật Khẩu')
@section('subheading', 'Nhập email đã đăng ký để nhận mã xác thực OTP')

@section('content')
    <form action="{{ route('password.sendOtp') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Email tài khoản</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@gmail.com" autofocus>
        </div>

        <button type="submit" class="btn-auth">Gửi mã xác thực OTP</button>
    </form>

    <div style="margin-top: 20px; text-align: center; font-size: 13px; color: #64748b;">
        Nhớ lại mật khẩu? <a href="{{ route('login') }}" style="color: #0284c7; font-weight: 700; text-decoration: none;">Đăng nhập</a>
    </div>
@endsection