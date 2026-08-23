<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TOEIC VCATH - Học Tiếng Anh Trực Tuyến')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { 
            --primary: #0284c7; 
            --sidebar-width: 260px; 
            --text-dark: #1e293b; 
            --text-muted: #64748b; 
            --bg-light: #f8fafc; 
            --border-color: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-light); color: var(--text-dark); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { 
            width: var(--sidebar-width); 
            background: #ffffff; 
            border-right: 1px solid var(--border-color); 
            padding: 20px 14px; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            top: 0; 
            bottom: 0; 
            left: 0; 
            overflow-y: auto; 
            z-index: 100; 
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 10px 18px;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            text-decoration: none;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 16px;
        }
        .sidebar-brand span { color: var(--primary); }

        .nav-category { 
            font-size: 11px; 
            font-weight: 800; 
            letter-spacing: 0.8px; 
            color: #94a3b8; 
            margin: 16px 10px 6px; 
            text-transform: uppercase;
        }
        
        .nav-item { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 9px 12px; 
            color: #475569; 
            text-decoration: none; 
            font-size: 13.5px; 
            font-weight: 600; 
            border-radius: 8px; 
            transition: all 0.2s ease; 
            margin-bottom: 2px; 
        }
        .nav-item svg { width: 18px; height: 18px; stroke-width: 2; flex-shrink: 0; }
        .nav-item:hover { background: #f1f5f9; color: var(--text-dark); }
        .nav-item.active { background: #e0f2fe; color: #0284c7; font-weight: 700; }

        /* Main Wrapper */
        .main-wrapper { margin-left: var(--sidebar-width); flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .top-header { 
            height: 64px; 
            background: #ffffff; 
            border-bottom: 1px solid var(--border-color); 
            display: flex; 
            align-items: center; 
            justify-content: flex-end; 
            padding: 0 36px; 
            gap: 14px; 
            position: sticky; 
            top: 0; 
            z-index: 90; 
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 36px 24px; width: 100%; }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
            margin-right: 6px;
        }
        .lang-link {
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            color: #64748b;
            transition: all 0.2s;
        }
        .lang-link.active {
            background: #ffffff;
            color: var(--primary);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Modal */
        .auth-modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999;
            opacity: 0; visibility: hidden;
            transition: all 0.25s ease-in-out;
        }
        .auth-modal-overlay.active { opacity: 1; visibility: visible; }
        .auth-modal {
            background: white; border-radius: 18px; padding: 32px;
            max-width: 400px; width: 90%; text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            transform: scale(0.92); transition: transform 0.25s ease-in-out;
            position: relative;
        }
        .auth-modal-overlay.active .auth-modal { transform: scale(1); }
        .auth-modal-icon { width: 56px; height: 56px; background: #e0f2fe; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 16px; }
        .auth-modal h3 { font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .auth-modal p { font-size: 13.5px; color: var(--text-muted); line-height: 1.5; margin-bottom: 22px; }
        .auth-modal-buttons { display: flex; flex-direction: column; gap: 8px; }
        .btn-modal-primary { background: #0284c7; color: white; padding: 11px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px; }
        .btn-modal-register { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 11px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 14px; }
        .btn-modal-secondary { background: #f8fafc; color: #64748b; padding: 10px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 13px; border: none; cursor: pointer; }
        .btn-modal-close { position: absolute; top: 14px; right: 16px; background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div>
            <!-- Logo -->
            <a href="{{ route('courses.index') }}" class="sidebar-brand">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.5"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                TOEIC <span>VCATH</span>
            </a>

            <!-- Home -->
            <a href="{{ route('courses.index') }}" class="nav-item {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                {{ __('messages.home') }}
            </a>

            <!-- MODULES Section -->
            <div class="nav-category">{{ __('messages.modules') }}</div>

            <!-- 1. Grammar Course -->
            <a href="{{ route('grammar.index') }}" class="nav-item {{ request()->routeIs('grammar.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                {{ __('messages.grammar_course') }}
            </a>

            <!-- 2. Grammar Practice -->
            <a href="{{ route('grammar_practice.index') }}" class="nav-item {{ request()->routeIs('grammar_practice.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                {{ __('messages.grammar_practice') }}
            </a>

            <!-- 3. Listening -->
            <a href="{{ route('listening.index') }}" class="nav-item {{ request()->routeIs('listening.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
                {{ __('messages.listening') }}
            </a>

            <!-- 4. Mock test LR -->
            <a href="{{ route('mock_test.index') }}" class="nav-item {{ request()->routeIs('mock_test.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                {{ __('messages.mock_test_lr') }}
            </a>

            <!-- 5. Mock test SW -->
            <a href="{{ route('mock_test_sw.index') }}" class="nav-item {{ request()->routeIs('mock_test_sw.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                {{ __('messages.mock_test_sw') }}
            </a>

            <!-- 6. Writing -->
            <a href="{{ route('writing_practice.index') }}" class="nav-item {{ request()->routeIs('writing_practice.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                {{ __('messages.writing') }}
            </a>

            <!-- 7. Vocabulary -->
            <a href="{{ route('vocabularies.index') }}" class="nav-item {{ request()->routeIs('vocabularies.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                {{ __('messages.vocabulary') }}
            </a>

            <!-- 8. Reading -->
            <a href="{{ route('reading.index') }}" class="nav-item {{ request()->routeIs('reading.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                {{ __('messages.reading') }}
            </a>

            <!-- 9. Community -->
            <a href="{{ route('community.index') }}" class="nav-item {{ request()->routeIs('community.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                {{ __('messages.community') }}
            </a>

            <!-- MORE Section -->
            <div class="nav-category">{{ __('messages.more') }}</div>

            <!-- Arena -->
            <a href="{{ route('arena.index') }}" class="nav-item {{ request()->routeIs('arena.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                {{ __('messages.arena') }}
            </a>

            <!-- Blog -->
            <a href="{{ route('blog.index') }}" class="nav-item {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                {{ __('messages.blog') }}
            </a>

            <!-- Leaderboard -->
            <a href="{{ route('leaderboard.index') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                {{ __('messages.leaderboard') }}
            </a>

            <!-- Hall of Fame -->
            <a href="{{ route('hall_of_fame.index') }}" class="nav-item {{ request()->routeIs('hall_of_fame.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14v2H5v-2z"/></svg>
                {{ __('messages.hall_of_fame') }}
            </a>

            <!-- Feedback -->
            <a href="{{ route('feedback.index') }}" class="nav-item {{ request()->routeIs('feedback.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5.76.76 1.23 1.52 1.41 2.5"/></svg>
                {{ __('messages.feedback') }}
            </a>

            <!-- Open Public Site -->
            <a href="{{ route('courses.index') }}" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>
                {{ __('messages.open_site') }}
            </a>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="top-header">
            <!-- Nút chọn Ngôn Ngữ VN / EN -->
            <div class="lang-switcher">
                <a href="{{ route('lang.switch', 'vi') }}" class="lang-link {{ app()->getLocale() == 'vi' ? 'active' : '' }}">VN</a>
                <a href="{{ route('lang.switch', 'en') }}" class="lang-link {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            </div>

            @auth
                <div style="font-size: 14px; font-weight: 600;">
                    {{ app()->getLocale() == 'vi' ? 'Chào mừng,' : 'Welcome,' }} <b>{{ Auth::user()->name }}</b>
                </div>
                <a href="{{ route('student.dashboard') }}" style="font-size: 14px; font-weight: 600; color: #059669; text-decoration: none;">
                    {{ app()->getLocale() == 'vi' ? 'Tiến độ học' : 'Progress' }}
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" style="font-size: 14px; font-weight: 600; color: #0284c7; text-decoration: none;">
                        Dashboard Admin
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 600; cursor: pointer;">
                        {{ __('messages.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('register') }}" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700;">
                    {{ __('messages.register') }}
                </a>
                <a href="{{ route('login') }}" style="background: #0284c7; color: #ffffff; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">
                    {{ __('messages.login') }}
                </a>
            @endauth
        </header>

        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Modal Yêu Cầu Đăng Nhập Toàn Cục -->
    <div id="authRequiredModal" class="auth-modal-overlay" onclick="closeAuthModal(event)">
        <div class="auth-modal" onclick="event.stopPropagation()">
            <button class="btn-modal-close" onclick="closeAuthModal()">&times;</button>
            <div class="auth-modal-icon">🔒</div>
            <h3>{{ app()->getLocale() == 'vi' ? 'Yêu Cầu Tài Khoản' : 'Account Required' }}</h3>
            <p>{{ app()->getLocale() == 'vi' ? 'Vui lòng đăng nhập hoặc tạo tài khoản TOEIC VCATH để sử dụng' : 'Please sign in or create a TOEIC VCATH account to use' }} <span id="authModalFeature" style="color: #0284c7; font-weight: 700;"></span>.</p>
            <div class="auth-modal-buttons">
                <a href="{{ route('login') }}" class="btn-modal-primary">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}" class="btn-modal-register">{{ __('messages.register') }}</a>
                <button type="button" onclick="closeAuthModal()" class="btn-modal-secondary">{{ app()->getLocale() == 'vi' ? 'Để sau' : 'Cancel' }}</button>
            </div>
        </div>
    </div>

    <script>
        function openAuthModal(featureName = 'tính năng này') {
            document.getElementById('authModalFeature').innerText = featureName;
            document.getElementById('authRequiredModal').classList.add('active');
        }
        function closeAuthModal() {
            document.getElementById('authRequiredModal').classList.remove('active');
        }
    </script>
    @stack('scripts')
</body>
</html>