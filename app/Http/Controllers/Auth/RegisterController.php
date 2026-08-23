<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerifyOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'citizen_id' => ['required', 'string', 'digits_between:9,12', 'unique:users,citizen_id'],
            'phone' => ['required', 'regex:/^[0-9]{10,11}$/', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'username.required' => 'Vui lòng nhập tên tài khoản.',
            'username.unique' => 'Tên tài khoản này đã được sử dụng.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.unique' => 'Email này đã tồn tại trên hệ thống.',
            'citizen_id.required' => 'Vui lòng nhập số CCCD/CMND.',
            'citizen_id.digits_between' => 'Số CCCD không hợp lệ (từ 9 đến 12 số).',
            'citizen_id.unique' => 'Số CCCD này đã được đăng ký.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải từ 10 - 11 chữ số.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải tối thiểu 6 ký tự.',
            'password.confirmed' => 'Xác minh mật khẩu không khớp.',
        ]);

        $otp = (string) rand(100000, 999999);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'citizen_id' => $validated['citizen_id'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'verification_code' => $otp,
            'code_expires_at' => Carbon::now()->addSeconds(60), // Hết hạn trong 60 giây
        ]);

        try {
            Mail::to($user->email)->send(new VerifyOtpMail($otp, $user->name));
        } catch (\Exception $e) {
            $user->delete();
            return back()->withInput()->withErrors(['email' => 'Không thể gửi email OTP: ' . $e->getMessage()]);
        }

        return redirect()->route('register.verify', ['email' => $user->email])
                         ->with('success', 'Mã xác thực đã được gửi về email của bạn!');
    }

    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify', compact('email'));
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
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn sau 60 giây, vui lòng bấm gửi lại mã.']);
        }

        $user->email_verified_at = Carbon::now();
        $user->verification_code = null;
        $user->code_expires_at = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('courses.index')->with('success', 'Xác thực tài khoản thành công!');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('success', 'Tài khoản đã được xác thực trước đó, hãy đăng nhập.');
        }

        $otp = (string) rand(100000, 999999);
        $user->verification_code = $otp;
        $user->code_expires_at = Carbon::now()->addSeconds(60);
        $user->save();

        try {
            Mail::to($user->email)->send(new VerifyOtpMail($otp, $user->name));
            return back()->with('success', 'Mã xác thực mới đã được gửi về email!');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Lỗi khi gửi lại mail: ' . $e->getMessage()]);
        }
    }
}