<?php

namespace Database\Seeders;

use App\Models\ListeningLesson;
use App\Models\ListeningQuestion;
use Illuminate\Database\Seeder;

class ListeningSeeder extends Seeder
{
    public function run(): void
    {
        // Bài tập mẫu Part 1
        $lesson1 = ListeningLesson::updateOrCreate(
            ['slug' => 'part-1-mo-ta-tranh-van-phong'],
            [
                'title' => 'Part 1: Luyện nghe mô tả tranh - Hành động tại văn phòng',
                'part' => 'part_1',
                'description' => 'Tập trung vào hành động của con người và vị trí các đồ vật trong phòng họp.',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', // Link test mẫu
                'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60',
                'transcript' => '<p>(A) They are walking out of the conference room.</p>
                                 <p>(B) They are looking at a laptop together.</p>
                                 <p>(C) A man is cleaning the whiteboard.</p>
                                 <p>(D) All chairs are being moved to the hallway.</p>',
                'order_index' => 1,
            ]
        );

        ListeningQuestion::updateOrCreate(
            ['listening_lesson_id' => $lesson1->id, 'question' => 'Chọn phát biểu mô tả đúng nhất về bức tranh:'],
            [
                'option_a' => 'They are walking out of the conference room.',
                'option_b' => 'They are looking at a laptop together.',
                'option_c' => 'A man is cleaning the whiteboard.',
                'option_d' => 'All chairs are being moved to the hallway.',
                'correct_answer' => 'B',
                'explanation' => 'Trong ảnh mọi người đang cùng nhau ngồi trước màn hình laptop trao đổi công việc.'
            ]
        );

        // Bài tập mẫu Part 2
        $lesson2 = ListeningLesson::updateOrCreate(
            ['slug' => 'part-2-cau-hoi-where-when'],
            [
                'title' => 'Part 2: Luyện nghe câu hỏi Where & When',
                'part' => 'part_2',
                'description' => 'Mẹo bắt từ khóa Where (nơi chốn) và When (thời gian) tránh các bẫy đồng âm.',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
                'image_url' => null,
                'transcript' => '<p><b>Question:</b> Where did you leave the contract files?</p>
                                 <p>(A) On Mr. David\'s desk.</p>
                                 <p>(B) Yes, I signed it yesterday.</p>
                                 <p>(C) At 3:00 PM today.</p>',
                'order_index' => 2,
            ]
        );

        ListeningQuestion::updateOrCreate(
            ['listening_lesson_id' => $lesson2->id, 'question' => 'Listen and choose the best response:'],
            [
                'option_a' => 'On Mr. David\'s desk.',
                'option_b' => 'Yes, I signed it yesterday.',
                'option_c' => 'At 3:00 PM today.',
                'option_d' => null,
                'correct_answer' => 'A',
                'explanation' => 'Câu hỏi "Where" hỏi về nơi chốn, đáp án A đưa ra vị trí "Trên bàn ông David". Loại B vì câu hỏi WH không trả lời Yes/No.'
            ]
        );
    }
}