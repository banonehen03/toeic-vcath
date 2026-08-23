<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Phòng Học Trực Tuyến')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; display: flex; height: 100vh; background: #f8fafc; color: #1e293b; overflow: hidden; }
        
        /* Sidebar */
        .sidebar { width: 320px; background: #0f172a; color: #fff; padding: 24px 16px; display: flex; flex-direction: column; flex-shrink: 0; overflow-y: auto; }
        .back-link { color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 6px; }
        .back-link:hover { color: #38bdf8; }
        .sidebar h3 { font-size: 16px; font-weight: 700; color: #f8fafc; margin-bottom: 4px; }
        .course-level { font-size: 12px; color: #38bdf8; font-weight: 600; text-transform: uppercase; margin-bottom: 16px; }
        .lesson-list { display: flex; flex-direction: column; gap: 6px; border-top: 1px solid #334155; padding-top: 16px; }
        .lesson-item { display: block; color: #cbd5e1; padding: 12px 14px; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; background: #1e293b; transition: all 0.2s; }
        .lesson-item:hover { background: #334155; color: #fff; }
        .lesson-item.active { background: #0284c7; color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3); }

        /* Main Content */
        .main-content { flex: 1; padding: 40px 60px; overflow-y: auto; }
        .lesson-header { margin-bottom: 24px; }
        .lesson-header h2 { font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .hint-bar { font-size: 14px; color: #64748b; background: #e0f2fe; padding: 10px 16px; border-radius: 8px; display: inline-block; }

        /* Video Player */
        .video-container { margin-top: 20px; position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }

        /* Reading Card */
        .reading-card { background: #fff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-top: 20px; font-size: 18px; line-height: 2; color: #334155; user-select: text; }

        /* Popup Dictionary */
        #dict-popup {
            display: none; position: absolute; background: #ffffff; border: 1px solid #e2e8f0;
            box-shadow: 0 12px 30px rgba(0,0,0,0.15); padding: 18px; border-radius: 12px;
            width: 310px; z-index: 9999; animation: fadeIn 0.15s ease-in-out;
        }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.96); } to { opacity: 1; transform: scale(1); } }
        .pop-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; }
        .pop-word { margin: 0; color: #0284c7; font-size: 20px; font-weight: 700; }
        .pop-actions { display: flex; gap: 6px; }
        .btn-action { background: #f1f5f9; border: 1px solid #e2e8f0; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s; font-size: 14px; }
        .btn-action:hover { background: #e2e8f0; }
        .pop-ipa { color: #e11d48; font-style: italic; margin-bottom: 10px; font-size: 13px; font-weight: 600; }
        .meaning-list { max-height: 180px; overflow-y: auto; }
        .meaning-item { font-size: 13px; margin-bottom: 8px; border-bottom: 1px dashed #f1f5f9; padding-bottom: 6px; line-height: 1.5; }
        .pos { font-weight: 700; color: #059669; }
        .save-toast { font-size: 12px; color: #059669; font-weight: 700; margin-top: 8px; text-align: center; display: none; background: #ecfdf5; padding: 4px 8px; border-radius: 6px; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar danh sách bài học -->
    <aside class="sidebar">
        @yield('sidebar')
    </aside>

    <!-- Khu vực nội dung bài học -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Popup tra từ điển dùng chung -->
    <div id="dict-popup">
        <div class="pop-header">
            <h4 class="pop-word" id="pop-word">Loading...</h4>
            <div class="pop-actions">
                <button class="btn-action" id="btn-speaker" title="Nghe phát âm" onclick="speakCurrentWord()">🔊</button>
                <button class="btn-action" id="btn-save-vocab" title="Lưu vào Sổ tay từ vựng" onclick="saveCurrentWord()" style="color: #f59e0b;">⭐</button>
            </div>
        </div>
        <div class="pop-ipa" id="pop-ipa"></div>
        <div class="meaning-list" id="pop-definitions"></div>
        <div id="save-msg" class="save-toast"></div>
    </div>

    @stack('scripts')
</body>
</html>