@extends('layouts.auth')

@section('title', 'Xác minh mã OTP - TOEIC VCATH')
@section('heading', 'Xác Minh Mã OTP')
@section('subheading', 'Nhập mã xác thực 6 số được gửi về hòm thư của bạn')

@section('content')
    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 16px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('password.verify.submit') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="form-group">
            <label style="text-align: center; display: block; margin-bottom: 6px;">Mã OTP gửi đến: <b>{{ $email }}</b></label>
            <input type="text" name="otp" maxlength="6" required autofocus placeholder="123456" 
                   style="text-align: center; font-size: 26px; letter-spacing: 6px; font-weight: 800; color: #0284c7;">
        </div>

        <div id="countdown-box" style="text-align: center; font-size: 13px; color: #e11d48; margin-bottom: 14px; font-weight: 600;">
            Mã hết hạn sau: <span id="timer" style="font-size: 15px;">60</span>s
        </div>

        <button type="submit" class="btn-auth">Xác minh OTP</button>
    </form>

    <div style="margin-top: 18px; text-align: center;">
        <form id="resend-form" action="{{ route('password.resendOtp') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" style="background: none; border: none; color: #0284c7; font-weight: 700; cursor: pointer; text-decoration: underline; font-size: 14px;">
                🔄 Gửi lại mã xác minh mới
            </button>
        </form>
    </div>

    <script>
        let timeLeft = 60;
        const timerDisplay = document.getElementById('timer');
        const countdownBox = document.getElementById('countdown-box');
        const resendForm = document.getElementById('resend-form');

        const countdownInterval = setInterval(() => {
            timeLeft--;
            timerDisplay.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdownBox.innerHTML = '<span style="color: #ef4444;">Mã OTP đã hết hạn! Vui lòng gửi lại mã mới bên dưới.</span>';
                resendForm.style.display = 'block';
            }
        }, 1000);
    </script>
@endsection