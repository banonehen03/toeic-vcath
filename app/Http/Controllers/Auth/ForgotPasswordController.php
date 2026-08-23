<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerifyOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Bước 1: Màn hình nhập Email
    public function showEmailForm()
    {
        return view('auth.forgot-password-email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.exists' => 'Email này chưa được đăng ký trong hệ thống.',
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = (string) rand(100000, 999999);

        $user->verification_code = $otp;
        $user->code_expires_at = Carbon::now()->addSeconds(60);
        $user->save();

        try {
            Mail::to($user->email)->send(new VerifyOtpMail($otp, $user->name));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['email' => 'Không thể gửi email OTP: ' . $e->getMessage()]);
        }

        return redirect()->route('password.verify.form', ['email' => $user->email])
                         ->with('success', 'Mã xác thực 6 số đã được gửi đến email!');
    }

    // Bước 2: Màn hình nhập và Xác minh mã OTP
    public function showVerifyOtpForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('password.request');
        }
        return view('auth.forgot-password-verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP 6 số.',
            'otp.size' => 'Mã OTP phải có đúng 6 chữ số.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->verification_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

        if (Carbon::now()->gt($user->code_expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn sau 60 giây. Vui lòng bấm gửi lại mã.']);
        }

        // Lưu trạng thái đã xác minh vào Session tạm thời
        session(['password_reset_verified_email' => $user->email]);

        return redirect()->route('password.new.form')
                         ->with('success', 'Xác minh OTP thành công! Vui lòng thiết lập mật khẩu mới.');
    }

    // Bước 3: Màn hình Đặt Mật Khẩu Mới
    public function showNewPasswordForm()
    {
        $email = session('password_reset_verified_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Phiên xác thực đã hết hạn, vui lòng làm lại từ đầu.']);
        }
        return view('auth.forgot-password-new', compact('email'));
    }

    public function saveNewPassword(Request $request)
    {
        $email = session('password_reset_verified_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Phiên xác thực đã hết hạn.']);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->verification_code = null;
        $user->code_expires_at = null;
        $user->save();

        session()->forget('password_reset_verified_email');

        return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công! Hãy đăng nhập bằng mật khẩu mới.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        $otp = (string) rand(100000, 999999);
        $user->verification_code = $otp;
        $user->code_expires_at = Carbon::now()->addSeconds(60);
        $user->save();

        try {
            Mail::to($user->email)->send(new VerifyOtpMail($otp, $user->name));
            return back()->with('success', 'Mã OTP mới đã được gửi lại về email!');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Lỗi gửi lại mã: ' . $e->getMessage()]);
        }
    }
}