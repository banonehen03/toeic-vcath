<?php

namespace Database\Seeders;

use App\Models\ReadingLesson;
use App\Models\ReadingQuestion;
use Illuminate\Database\Seeder;

class ReadingSeeder extends Seeder
{
    public function run(): void
    {
        // Bài đọc mẫu Part 7: Email thông báo bảo trì máy chủ
        $lesson1 = ReadingLesson::updateOrCreate(
            ['slug' => 'part-7-thong-bao-bao-tri-he-thong'],
            [
                'title' => 'Part 7: Thông báo nội bộ về việc nâng cấp máy chủ',
                'part' => 'part_7',
                'description' => 'Luyện kỹ năng Skimming & Scanning tìm thông tin thời gian và yêu cầu hành động.',
                'passage' => '<p><b>To:</b> All Staff Members &lt;staff@techcorp.com&gt;<br>
                             <b>From:</b> IT Department &lt;support@techcorp.com&gt;<br>
                             <b>Date:</b> October 14, 2026<br>
                             <b>Subject:</b> Scheduled System Maintenance Notice</p>
                             <hr style="margin: 10px 0; border: none; border-top: 1px solid #e2e8f0;">
                             <p>Please be advised that our central database servers will undergo critical maintenance this coming Saturday, October 18, starting at 10:00 PM and concluding by 4:00 AM Sunday morning.</p>
                             <p>During this 6-hour maintenance window, access to the internal ERP software, shared cloud folders, and corporate email accounts will be temporarily suspended. All employees are strongly requested to save all pending files and log out of their workstations before 9:30 PM on Friday.</p>
                             <p>If you encounter any unexpected system errors on Monday morning, please submit a ticket to the IT helpdesk immediately.</p>',
                'image_url' => null,
                'order_index' => 1,
                'is_published' => true,
            ]
        );

        ReadingQuestion::updateOrCreate(
            ['reading_lesson_id' => $lesson1->id, 'question' => 'What is the main purpose of the email?'],
            [
                'option_a' => 'To announce a new IT manager hiring',
                'option_b' => 'To notify employees about server maintenance',
                'option_c' => 'To cancel an upcoming corporate event',
                'option_d' => 'To introduce a new cloud storage plan',
                'correct_answer' => 'B',
                'explanation' => 'Dựa vào tiêu đề "Scheduled System Maintenance Notice" và câu đầu tiên của email, mục đích là thông báo lịch bảo trì hệ thống máy chủ.'
            ]
        );

        ReadingQuestion::updateOrCreate(
            ['reading_lesson_id' => $lesson1->id, 'question' => 'How long is the maintenance expected to last?'],
            [
                'option_a' => '4 hours',
                'option_b' => '6 hours',
                'option_c' => '8 hours',
                'option_d' => '24 hours',
                'correct_answer' => 'B',
                'explanation' => 'Đoạn 2 nêu rõ: "During this 6-hour maintenance window..." (từ 10:00 PM đến 4:00 AM, kéo dài 6 tiếng).'
            ]
        );

        // Bài đọc mẫu Part 5: Hoàn thành câu
        $lesson2 = ReadingLesson::updateOrCreate(
            ['slug' => 'part-5-luyen-tap-ngu-phap-tu-vung-01'],
            [
                'title' => 'Part 5: Hoàn thành câu - Ngữ pháp & Từ vựng kinh doanh',
                'part' => 'part_5',
                'description' => 'Tổng hợp các câu trắc nghiệm ngữ pháp và chọn từ đúng theo ngữ cảnh công sở.',
                'passage' => null,
                'image_url' => null,
                'order_index' => 2,
                'is_published' => true,
            ]
        );

        ReadingQuestion::updateOrCreate(
            ['reading_lesson_id' => $lesson2->id, 'question' => 'The marketing team worked _______ to finalize the promotional campaign before the deadline.'],
            [
                'option_a' => 'diligence',
                'option_b' => 'diligently',
                'option_c' => 'diligent',
                'option_d' => 'most diligent',
                'correct_answer' => 'B',
                'explanation' => 'Cần một trạng từ (adv) "diligently" đứng sau động từ "worked" để bổ nghĩa cho hành động.'
            ]
        );
    }
}