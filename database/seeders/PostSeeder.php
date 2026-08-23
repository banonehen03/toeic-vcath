<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first() ?? User::create([
            'name' => 'Admin VCATH',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin'
        ]);

        $posts = [
            [
                'title' => 'Chiến thuật tránh bẫy thì và giới từ trong TOEIC Part 5',
                'category' => 'Mẹo thi TOEIC',
                'summary' => 'Hướng dẫn nhận diện nhanh các chủ điểm ngữ pháp hay gặp và bẫy thời gian trong Part 5.',
                'content' => '<p>Trong bài thi TOEIC Part 5, có tới 30% câu hỏi kiểm tra về thì và sự hòa hợp giữa chủ ngữ - động từ. Để làm bài nhanh trong vòng 10-15 giây mỗi câu, bạn cần chú ý các dấu hiệu sau:</p>
                              <h3>1. Dấu hiệu trạng từ chỉ thời gian</h3>
                              <p>Các từ như <i>recently, lately</i> thường đi với Hiện tại hoàn thành, trong khi <i>prior to, by the time</i> liên quan đến quá khứ hoàn thành hoặc tương lai hoàn thành.</p>
                              <h3>2. Xác định chủ ngữ chính trong câu</h3>
                              <p>Cẩn thận với các cụm giới từ chen giữa chủ ngữ và động từ chính, ví dụ: "The list of approved vendors <b>is</b> ready" (chủ ngữ là list, số ít).</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&q=80',
            ],
            [
                'title' => 'Lộ trình tự học TOEIC từ 0 lên 650+ hiệu quả trong 3 tháng',
                'category' => 'Lộ trình học',
                'summary' => 'Chia nhỏ mục tiêu theo từng tháng, tập trung vào từ vựng công sở và kỹ năng nghe Part 1-3.',
                'content' => '<p>Lộ trình 3 tháng được thiết kế cho người mất gốc hoặc bắt đầu từ band điểm 300:</p>
                              <ul>
                                <li><b>Tháng 1:</b> Củng cố ngữ pháp nền tảng (8 thì cơ bản, từ loại, mệnh đề quan hệ) và học 600 từ vựng cốt lõi.</li>
                                <li><b>Tháng 2:</b> Luyện chuyên sâu Listening Part 1, 2 và Reading Part 5, 6 theo từng chuyên đề.</li>
                                <li><b>Tháng 3:</b> Giải đề hoàn chỉnh bấm giờ 120 phút trên hệ thống để rèn phản xạ và thể lực.</li>
                              </ul>',
                'thumbnail' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&q=80',
            ],
        ];

        foreach ($posts as $item) {
            Post::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'user_id' => $admin->id,
                    'title' => $item['title'],
                    'category' => $item['category'],
                    'summary' => $item['summary'],
                    'content' => $item['content'],
                    'thumbnail' => $item['thumbnail'],
                    'views_count' => rand(20, 150),
                    'is_published' => true,
                ]
            );
        }
    }
}