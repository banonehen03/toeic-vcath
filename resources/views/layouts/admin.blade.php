<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TOEIC VCATH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 40px 20px; color: #0f172a; }
        .container { max-width: 950px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .header h2 { font-size: 22px; font-weight: 800; }
        .header-links { display: flex; align-items: center; gap: 14px; }
        
        .btn-back { color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.2s; }
        .btn-back:hover { color: #0f172a; }
        .btn-back.active { color: #0284c7; font-weight: 700; }

        .btn-primary-admin, .btn-add { 
            background: #059669; 
            color: #ffffff; 
            padding: 10px 18px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 14px; 
            border: none; 
            cursor: pointer; 
            display: inline-block;
            transition: background 0.2s; 
        }
        .btn-primary-admin:hover, .btn-add:hover { background: #047857; }

        .alert-success { background: #ecfdf5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: 600; border: 1px solid #a7f3d0; }
        
        /* Table Styles */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        th { background: #f8fafc; color: #64748b; font-weight: 700; font-size: 13px; text-transform: uppercase; }
        .btn-action { color: #0284c7; text-decoration: none; font-weight: 600; }
        .btn-action:hover { text-decoration: underline; }
        
        /* Form Styles */
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 14px; color: #334155; }
        input[type="text"], input[type="number"], input[type="email"], input[type="password"], textarea, select { 
            width: 100%; 
            padding: 10px 14px; 
            border: 1px solid #cbd5e1; 
            border-radius: 8px; 
            font-family: inherit; 
            font-size: 14px; 
            outline: none; 
            transition: border-color 0.2s; 
        }
        input:focus, textarea:focus, select:focus { border-color: #0284c7; }
        .btn-submit { background: #0284c7; color: white; border: none; padding: 12px 20px; border-radius: 8px; width: 100%; font-weight: 700; font-size: 15px; cursor: pointer; }
        .btn-submit:hover { background: #0369a1; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>@yield('page-title')</h2>
            <div class="header-links">
                <a href="{{ route('admin.courses.index') }}" class="btn-back {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">Khóa học</a>
                <a href="{{ route('admin.questions.index') }}" class="btn-back {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}">Ngân hàng câu hỏi</a>
                <a href="{{ route('courses.index') }}" class="btn-back">&larr; Về trang chủ</a>
                @yield('header-actions')
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>