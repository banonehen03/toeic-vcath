<?php

namespace Database\Seeders;

use App\Models\GrammarLesson;
use App\Models\GrammarQuestion;
use Illuminate\Database\Seeder;

class GrammarQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $presentSimpleLesson = GrammarLesson::where('slug', 'thi-hien-tai-don')->first();
        $passiveVoiceLesson = GrammarLesson::where('slug', 'cau-bi-dong')->first();

        if ($presentSimpleLesson) {
            GrammarQuestion::create([
                'grammar_lesson_id' => $presentSimpleLesson->id,
                'question' => 'Mr. Tanaka _______ monthly sales reports directly to the executive board every Friday.',
                'option_a' => 'submit',
                'option_b' => 'submits',
                'option_c' => 'submitted',
                'option_d' => 'submitting',
                'correct_answer' => 'B',
                'explanation' => 'Chủ ngữ "Mr. Tanaka" là ngôi thứ 3 số ít và câu có trạng từ chỉ tần suất "every Friday" nên động từ chia ở Hiện tại đơn thêm -s (submits).'
            ]);

            GrammarQuestion::create([
                'grammar_lesson_id' => $presentSimpleLesson->id,
                'question' => 'The accounting team usually _______ travel reimbursement requests within three business days.',
                'option_a' => 'processes',
                'option_b' => 'processed',
                'option_c' => 'processing',
                'option_d' => 'process',
                'correct_answer' => 'A',
                'explanation' => 'Chủ ngữ tập hợp "The accounting team" được xem là danh từ số ít ở thì Hiện tại đơn (có từ "usually") -> chia "processes".'
            ]);
        }

        if ($passiveVoiceLesson) {
            GrammarQuestion::create([
                'grammar_lesson_id' => $passiveVoiceLesson->id,
                'question' => 'All employee evaluation forms must be _______ to HR before Friday afternoon.',
                'option_a' => 'deliver',
                'option_b' => 'delivered',
                'option_c' => 'delivering',
                'option_d' => 'delivery',
                'correct_answer' => 'B',
                'explanation' => 'Cấu trúc bị động với động từ khuyết thiếu: must + be + V3/ed. Do đó chọn "delivered".'
            ]);
        }
    }
}