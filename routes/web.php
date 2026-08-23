<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GrammarLessonController;
use App\Http\Controllers\GrammarPracticeController;
use App\Http\Controllers\ListeningController;
use App\Http\Controllers\MockExamController;
use App\Http\Controllers\MockExamSWController;
use App\Http\Controllers\WritingPracticeController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\CommunityController;

// Cộng đồng thảo luận
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/community/{id}', [CommunityController::class, 'show'])->name('community.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/community', [CommunityController::class, 'store'])->name('community.store');
    Route::post('/community/{id}/comment', [CommunityController::class, 'comment'])->name('community.comment');
    Route::post('/community/{id}/like', [CommunityController::class, 'toggleLike'])->name('community.like');
});

// Phía học viên
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Phía Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('feedback', AdminFeedbackController::class)->only(['index', 'update', 'destroy']);
});

// Bảng xếp hạng & Bảng vinh danh
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/hall-of-fame', [LeaderboardController::class, 'hallOfFame'])->name('hall_of_fame.index');

// Blog cho học viên
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Blog quản trị Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('blog', AdminBlogController::class)->only(['index', 'create', 'store', 'destroy']);
});

// Đấu trường (Arena)
Route::get('/arena', [ArenaController::class, 'index'])->name('arena.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/arena/play', [ArenaController::class, 'play'])->name('arena.play');
    Route::post('/arena/submit', [ArenaController::class, 'submit'])->name('arena.submit');
});

/*
|--------------------------------------------------------------------------
| 1. TRANG CHỦ, NGÔN NGỮ & XÁC THỰC (AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/', [CourseController::class, 'index'])->name('courses.index');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['vi', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Đăng nhập / Đăng xuất
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Đăng ký & Xác thực OTP
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/register/resend-otp', [RegisterController::class, 'resendOtp'])->name('register.resend');
Route::get('/register/verify', [RegisterController::class, 'showVerifyForm'])->name('register.verify');
Route::post('/register/verify', [RegisterController::class, 'verifyOtp'])->name('register.verify.post');

// Quên mật khẩu OTP
Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.sendOtp');
Route::get('/forgot-password/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verify.form');
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.submit');
Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resendOtp');
Route::get('/forgot-password/new-password', [ForgotPasswordController::class, 'showNewPasswordForm'])->name('password.new.form');
Route::post('/forgot-password/new-password', [ForgotPasswordController::class, 'saveNewPassword'])->name('password.new.submit');

/*
|--------------------------------------------------------------------------
| 2. CÁC MODULE HỌC TẬP (CLIENT-SIDE)
|--------------------------------------------------------------------------
*/
// 1. Khóa học Ngữ pháp
Route::get('/grammar-course', [GrammarLessonController::class, 'index'])->name('grammar.index');
Route::get('/grammar-course/{slug}', [GrammarLessonController::class, 'show'])->name('grammar.show');

// 2. Luyện tập Ngữ pháp
Route::get('/grammar-practice', [GrammarPracticeController::class, 'index'])->name('grammar_practice.index');
Route::get('/grammar-practice/{slug}', [GrammarPracticeController::class, 'practice'])->name('grammar_practice.practice');

// 3. Luyện nghe Listening
Route::get('/listening', [ListeningController::class, 'index'])->name('listening.index');
Route::get('/listening/{slug}', [ListeningController::class, 'practice'])->name('listening.practice');

// 4. Thi thử Mock Test L&R
Route::get('/mock-tests', [MockExamController::class, 'index'])->name('mock_test.index');

// 5. Thi thử Mock Test S&W
Route::get('/mock-tests-sw', [MockExamSWController::class, 'index'])->name('mock_test_sw.index');

// 6. Luyện viết Writing
Route::get('/writing-practice', [WritingPracticeController::class, 'index'])->name('writing_practice.index');
Route::get('/writing-practice/{slug}', [WritingPracticeController::class, 'practice'])->name('writing_practice.practice');

// 7. Sổ tay từ vựng & Flashcards
Route::get('/vocabularies', [VocabularyController::class, 'index'])->name('vocabularies.index');
Route::get('/vocabularies/{slug}', [VocabularyController::class, 'show'])->name('vocabularies.show');

// 8. Luyện đọc Reading
Route::get('/reading', [ReadingController::class, 'index'])->name('reading.index');
Route::get('/reading/{slug}', [ReadingController::class, 'practice'])->name('reading.practice');

// Quiz chung
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz/submit', [QuizController::class, 'submit'])->name('quiz.submit');

/*
|--------------------------------------------------------------------------
| 3. KHU VỰC YÊU CẦU ĐĂNG NHẬP (USER / STUDENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard học viên
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

    // Mua khóa học & Học bài
    Route::post('/course/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/course/{courseId}/lesson/{lessonId}', [CourseController::class, 'learn'])->name('courses.learn');

    // Làm bài & Nộp bài thi L&R
    Route::get('/mock-tests/{slug}/take', [MockExamController::class, 'take'])->name('mock_test.take');
    Route::post('/mock-tests/{id}/submit', [MockExamController::class, 'submit'])->name('mock_test.submit');
    Route::get('/mock-tests/result/{resultId}', [MockExamController::class, 'result'])->name('mock_test.result');

    // Làm bài & Nộp bài thi S&W
    Route::get('/mock-tests-sw/{slug}/take', [MockExamSWController::class, 'take'])->name('mock_test_sw.take');
    Route::post('/mock-tests-sw/{id}/submit', [MockExamSWController::class, 'submit'])->name('mock_test_sw.submit');
    Route::get('/mock-tests-sw/result/{resultId}', [MockExamSWController::class, 'result'])->name('mock_test_sw.result');

    // Nộp bài tập Writing
    Route::post('/writing-practice/{id}/submit', [WritingPracticeController::class, 'submit'])->name('writing_practice.submit');

    // Lưu & Xóa từ vựng sổ tay
    Route::post('/vocabularies/save', [VocabularyController::class, 'store'])->name('vocabularies.store');
    Route::delete('/vocabularies/{id}', [VocabularyController::class, 'destroy'])->name('vocabularies.destroy');
});

/*
|--------------------------------------------------------------------------
| 4. KHU VỰC QUẢN TRỊ VIÊN (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Chấm điểm bài thi Speaking & Writing
    Route::get('/grade-sw/{id}', [AdminDashboardController::class, 'gradeSW'])->name('grade_sw');
    Route::post('/grade-sw/{id}', [AdminDashboardController::class, 'saveGradeSW'])->name('save_grade_sw');

    // Quản lý Khóa học & Bài giảng
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/lessons/create', [AdminCourseController::class, 'addLesson'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [AdminCourseController::class, 'storeLesson'])->name('lessons.store');

    // Quản lý Ngân hàng câu hỏi trắc nghiệm
    Route::resource('questions', AdminQuestionController::class)->only(['index', 'create', 'store', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| 5. KHU VỰC GIẢNG VIÊN (TEACHER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function () {
        return "<h2>Trang Giảng viên: Tạo bài học, quản lý nội dung video.</h2><a href='/'>Về trang chủ</a>";
    })->name('dashboard');
});