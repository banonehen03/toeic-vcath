<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::create([
            'lesson_id' => 1,
            'question_text' => 'The client requested that we revise the terms of the ______ before Friday.',
            'option_a' => 'contract',
            'option_b' => 'contractual',
            'option_c' => 'contractor',
            'option_d' => 'contracting',
            'correct_option' => 'A',
            'explanation' => 'Sau mạo từ "the" và trước giới từ "of" cần một danh từ số ít chỉ vật "contract" (hợp đồng).'
        ]);

        Question::create([
            'lesson_id' => 1,
            'question_text' => 'All software developers must sign a confidentiality ______ upon joining the company.',
            'option_a' => 'agree',
            'option_b' => 'agreement',
            'option_c' => 'agreeable',
            'option_d' => 'agreeably',
            'correct_option' => 'B',
            'explanation' => 'Cụm danh từ ghép "confidentiality agreement" nghĩa là thỏa thuận bảo mật.'
        ]);

        Question::create([
            'lesson_id' => 1,
            'question_text' => 'Mr. Tanaka will ______ the final version of the proposal tomorrow morning.',
            'option_a' => 'review',
            'option_b' => 'reviews',
            'option_c' => 'reviewed',
            'option_d' => 'reviewing',
            'correct_option' => 'A',
            'explanation' => 'Sau trợ động từ "will" cần một động từ nguyên mẫu không "to" (V-bare).'
        ]);
    }
}