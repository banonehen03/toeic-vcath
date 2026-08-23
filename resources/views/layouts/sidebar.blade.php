<style>
    .lang-btn {
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        transition: all 0.2s;
    }
    .lang-btn.active {
        background: #0284c7;
        color: #ffffff;
    }
</style>

<aside class="sidebar" style="width: 260px; min-height: 100vh; background: #ffffff; border-right: 1px solid #e2e8f0; padding: 20px 16px; display: flex; flex-direction: column; justify-content: space-between; font-family: sans-serif;">
    <div>
        <!-- Menu Chính -->
        <ul style="list-style: none; padding: 0; margin: 0 0 20px 0;">
            <li>
                <a href="{{ route('courses.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 14px; background: #e0f2fe; color: #0284c7; font-weight: 700; border-radius: 12px; text-decoration: none;">
                    <span>🏠</span> {{ __('messages.home') }}
                </a>
            </li>
        </ul>

        <!-- Nhóm MODULES -->
        <div style="font-size: 11px; font-weight: 800; color: #64748b; letter-spacing: 1px; margin-bottom: 10px; padding-left: 10px;">{{ __('messages.modules') }}</div>
        <ul style="list-style: none; padding: 0; margin: 0 0 20px 0; display: flex; flex-direction: column; gap: 4px;">
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🎓</span> {{ __('messages.grammar_course') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>📖</span> {{ __('messages.grammar_practice') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🎧</span> {{ __('messages.listening') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🏆</span> {{ __('messages.mock_test_lr') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🎙️</span> {{ __('messages.mock_test_sw') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>✏️</span> {{ __('messages.writing') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🔖</span> {{ __('messages.vocabulary') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>📚</span> {{ __('messages.reading') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>💬</span> {{ __('messages.community') }}</a></li>
        </ul>

        <!-- Nhóm MORE -->
        <div style="font-size: 11px; font-weight: 800; color: #64748b; letter-spacing: 1px; margin-bottom: 10px; padding-left: 10px;">{{ __('messages.more') }}</div>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px;">
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>⚡</span> {{ __('messages.arena') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>📰</span> {{ __('messages.blog') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🎖️</span> {{ __('messages.leaderboard') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>👑</span> {{ __('messages.hall_of_fame') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>💡</span> {{ __('messages.feedback') }}</a></li>
            <li><a href="#" style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; color: #475569; font-weight: 600; text-decoration: none; font-size: 13.5px;"><span>🏪</span> {{ __('messages.open_site') }}</a></li>
        </ul>
    </div>

    <!-- Nút Đổi Ngôn Ngữ -->
    <div style="padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; gap: 8px;">
        <span style="font-size: 13px; color: #64748b; font-weight: 600;">🌐 Ngôn ngữ:</span>
        <a href="{{ route('lang.switch', 'vi') }}" class="lang-btn {{ app()->getLocale() == 'vi' ? 'active' : '' }}">VN</a>
        <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
    </div>
</aside>