<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; padding: 30px; color: #0f172a;">
    <div style="max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <h2 style="color: #059669; margin-top: 0;">TOEIC VCATH</h2>
        <p>Xin chào <b>{{ $userName }}</b>,</p>
        <p>Cảm ơn bạn đã đăng ký tài khoản. Đây là mã xác thực OTP của bạn:</p>
        
        <div style="font-size: 32px; font-weight: bold; letter-spacing: 6px; color: #0284c7; text-align: center; padding: 18px 0; background: #f1f5f9; border-radius: 8px; margin: 20px 0;">
            {{ $otpCode }}
        </div>
        
        <p style="font-size: 13px; color: #64748b;">Mã có hiệu lực trong vòng 10 phút. Không chia sẻ mã này cho bất kỳ ai.</p>
    </div>
</body>
</html>