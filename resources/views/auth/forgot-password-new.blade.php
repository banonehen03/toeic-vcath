@extends('layouts.auth')

@section('title', 'Đặt mật khẩu mới - TOEIC VCATH')
@section('heading', 'Thiết Lập Mật Khẩu Mới')
@section('subheading', 'Nhập mật khẩu mới cho tài khoản: ' . $email)

@section('content')
    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 16px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('password.new.submit') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Mật khẩu mới</label>
            <input type="password" name="password" required autofocus placeholder="Tối thiểu 6 ký tự">
        </div>

        <div class="form-group">
            <label>Xác nhận lại mật khẩu mới</label>
            <input type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu">
        </div>

        <button type="submit" class="btn-auth">Đổi mật khẩu</button>
    </form>
@endsection