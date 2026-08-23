<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Hash;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Quản trị viên', 'password' => Hash::make('123456'), 'role' => 'admin']
        );

        // 2. Giảng viên
        User::updateOrCreate(
            ['email' => 'teacher@gmail.com'],
            ['name' => 'Giảng viên Tiếng Anh', 'password' => Hash::make('123456'), 'role' => 'teacher']
        );

        // 3. Học viên
        User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            ['name' => 'Học viên Test', 'password' => Hash::make('123456'), 'role' => 'student']
        );

        // Khóa học & bài học mẫu
        $course = Course::firstOrCreate(
            ['title' => 'Luyện thi TOEIC Cấp Tốc 450+'],
            ['description' => 'Khóa học tiếng Anh nền tảng', 'price' => 499000, 'level' => 'TOEIC 450+']
        );

        Lesson::firstOrCreate(
            ['course_id' => $course->id, 'title' => 'Unit 1: Business Contracts'],
            [
                'content' => "A contract is a legally binding agreement between parties. Software developers and engineers frequently review documents before signing a formal contract with their employers.",
                'order_number' => 1
            ]
        );
    }
}