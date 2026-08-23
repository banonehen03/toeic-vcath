<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đăng nhập') - Hệ Thống TOEIC</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            padding: 20px;
            color: #0f172a;
        }
        .auth-card { 
            background: #ffffff; 
            padding: 36px 32px; 
            border-radius: 16px; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04); 
            border: 1px solid #e2e8f0;
            width: 100%; 
            max-width: 400px; 
        }
        .auth-header { text-align: center; margin-bottom: 24px; }
        .auth-header h2 { font-size: 24px; font-weight: 800; }
        .auth-header p { font-size: 13px; color: #64748b; margin-top: 4px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 14px; color: #334155; }
        .form-group input { 
            width: 100%; 
            padding: 11px 14px; 
            border: 1px solid #cbd5e1; 
            border-radius: 8px; 
            font-family: inherit; 
            font-size: 14px; 
            outline: none;
            transition: border-color 0.2s;
        }
        .form-group input:focus { border-color: #0284c7; }

        .btn-auth { 
            width: 100%; 
            padding: 12px; 
            background: #0284c7; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-size: 15px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: background 0.2s;
            margin-top: 6px;
        }
        .btn-auth:hover { background: #0369a1; }

        .error-alert { 
            background: #fee2e2; 
            color: #991b1b; 
            padding: 10px 14px; 
            border-radius: 8px; 
            font-size: 13px; 
            font-weight: 600; 
            margin-bottom: 16px; 
        }
        .hint-box { 
            font-size: 12px; 
            color: #64748b; 
            margin-top: 20px; 
            background: #f8fafc; 
            padding: 12px 14px; 
            border-radius: 8px; 
            border: 1px dashed #cbd5e1;
            line-height: 1.6;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <h2>@yield('heading', 'Đăng Nhập')</h2>
            <p>@yield('subheading', 'Chào mừng bạn quay trở lại')</p>
        </div>

        @if($errors->any())
            <div class="error-alert">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>