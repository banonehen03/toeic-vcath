<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo tài khoản Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'citizen_id' => '001200000001',
                'phone' => '0987654321',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Tạo tài khoản Giảng viên (Teacher)
        User::updateOrCreate(
            ['email' => 'teacher@gmail.com'],
            [
                'name' => 'Giảng Viên TOEIC',
                'username' => 'teacher',
                'citizen_id' => '001200000002',
                'phone' => '0987654322',
                'password' => Hash::make('123456'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        // 3. Tạo tài khoản Học viên (Student)
        User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'Học Viên Mẫu',
                'username' => 'student',
                'citizen_id' => '001200000003',
                'phone' => '0987654323',
                'password' => Hash::make('123456'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        // Nạp toàn bộ dữ liệu mẫu các module
        $this->call([
            GrammarLessonSeeder::class,
            GrammarQuestionSeeder::class,
            ListeningSeeder::class,
            MockExamSeeder::class,
            MockExamSWSeeder::class,
            WritingTaskSeeder::class,
            VocabularySeeder::class,
            ReadingSeeder::class,
        ]);
    }
}