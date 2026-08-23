<?php

namespace Database\Seeders;

use App\Models\MockExam;
use App\Models\MockQuestion;
use Illuminate\Database\Seeder;

class MockExamSeeder extends Seeder
{
    public function run(): void
    {
        $exam = MockExam::updateOrCreate(
            ['slug' => 'toeic-full-mock-test-01'],
            [
                'title' => 'TOEIC Full Mock Test 2026 - Đề Thi Số 01',
                'description' => 'Bộ đề thi chuẩn format ETS gồm đầy đủ 2 phần Listening (Part 1 - 4) và Reading (Part 5 - 7).',
                'duration_minutes' => 120,
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                'is_published' => true,
            ]
        );

        // Câu hỏi 1 - Part 1
        MockQuestion::updateOrCreate(
            ['mock_exam_id' => $exam->id, 'question_number' => 1],
            [
                'section' => 'listening',
                'part_number' => 1,
                'question_text' => 'Listen and choose the statement that best describes the picture:',
                'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60',
                'audio_url' => null,
                'passage' => null,
                'option_a' => 'They are looking at a computer screen.',
                'option_b' => 'They are packing their luggage.',
                'option_c' => 'They are leaving the room.',
                'option_d' => 'They are drinking coffee.',
                'correct_answer' => 'A',
                'explanation' => 'Hình ảnh thể hiện các đồng nghiệp đang cùng nhau nhìn vào màn hình máy tính.'
            ]
        );

        // Câu hỏi 2 - Part 2
        MockQuestion::updateOrCreate(
            ['mock_exam_id' => $exam->id, 'question_number' => 2],
            [
                'section' => 'listening',
                'part_number' => 2,
                'question_text' => 'Where is the annual finance meeting going to be held?',
                'image_url' => null,
                'audio_url' => null,
                'passage' => null,
                'option_a' => 'Yes, at 10:00 AM.',
                'option_b' => 'In Conference Room B on the second floor.',
                'option_c' => 'Mr. Henderson organized it.',
                'option_d' => null,
                'correct_answer' => 'B',
                'explanation' => 'Câu hỏi "Where" hỏi về địa điểm, đáp án B chỉ rõ vị trí phòng họp.'
            ]
        );

        // Câu hỏi 3 - Part 5
        MockQuestion::updateOrCreate(
            ['mock_exam_id' => $exam->id, 'question_number' => 101],
            [
                'section' => 'reading',
                'part_number' => 5,
                'question_text' => 'Ms. Linda requested that the delivery schedule _______ immediately to avoid shipping delays.',
                'image_url' => null,
                'audio_url' => null,
                'passage' => null,
                'option_a' => 'be updated',
                'option_b' => 'updates',
                'option_c' => 'was updating',
                'option_d' => 'is updated',
                'correct_answer' => 'A',
                'explanation' => 'Cấu trúc câu giả định (Subjunctive): S + requested that + S + (should) + V_bare / be V3/ed.'
            ]
        );

        // Câu hỏi 4 - Part 5
        MockQuestion::updateOrCreate(
            ['mock_exam_id' => $exam->id, 'question_number' => 102],
            [
                'section' => 'reading',
                'part_number' => 5,
                'question_text' => 'Despite the heavy rain, the maintenance crew worked _______ to restore the factory power line.',
                'image_url' => null,
                'audio_url' => null,
                'passage' => null,
                'option_a' => 'efficiency',
                'option_b' => 'efficiently',
                'option_c' => 'efficient',
                'option_d' => 'efficiencies',
                'correct_answer' => 'B',
                'explanation' => 'Cần một trạng từ (adv) "efficiently" đứng sau động từ "worked" để bổ nghĩa cho hành động.'
            ]
        );
    }
}