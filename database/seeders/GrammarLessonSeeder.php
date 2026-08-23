<?php

namespace Database\Seeders;

use App\Models\GrammarLesson;
use Illuminate\Database\Seeder;

class GrammarLessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            [
                'title' => 'Bài 1: Thì Hiện Tại Đơn (Present Simple)',
                'slug' => 'thi-hien-tai-don',
                'level' => 'TOEIC 250 - 450',
                'summary' => 'Quy tắc chia động từ, dấu hiệu nhận biết (always, usually) và bẫy thì trong Part 5.',
                'order_index' => 1,
                'content' => '<h3>1. Cấu trúc câu khẳng định</h3>
                              <p><b>Công thức:</b> <code>S + V(s/es) + O</code></p>
                              <p>Ví dụ: <i>The marketing manager reviews sales reports every Monday.</i></p>
                              <h3>2. Dấu hiệu nhận biết trong TOEIC</h3>
                              <p>Trạng từ chỉ tần suất: Always, usually, frequently, often, rarely, never; các cụm từ: every day, every quarter, on Mondays.</p>'
            ],
            [
                'title' => 'Bài 2: Câu Bị Động (Passive Voice)',
                'slug' => 'cau-bi-dong',
                'level' => 'TOEIC 350 - 550',
                'summary' => 'Cấu trúc be + V3/ed và phương pháp làm nhanh câu hỏi chủ động/bị động.',
                'order_index' => 2,
                'content' => '<h3>1. Cấu trúc tổng quát</h3>
                              <p><b>Công thức:</b> <code>S + be + V3/ed + (by O)</code></p>
                              <p>Ví dụ: <i>All confidential documents are shredded before disposal.</i></p>
                              <h3>2. Mẹo làm bài Part 5</h3>
                              <p>Nếu sau chỗ trống không có tân ngữ trực tiếp (O), khả năng cao chọn dạng bị động.</p>'
            ]
        ];

        foreach ($lessons as $lesson) {
            GrammarLesson::updateOrCreate(['slug' => $lesson['slug']], $lesson);
        }
    }
}