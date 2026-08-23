<?php

namespace Database\Seeders;

use App\Models\MockExamSW;
use App\Models\MockQuestionSW;
use Illuminate\Database\Seeder;

class MockExamSWSeeder extends Seeder
{
    public function run(): void
    {
        $exam = MockExamSW::updateOrCreate(
            ['slug' => 'toeic-sw-mock-test-01'],
            [
                'title' => 'TOEIC Speaking & Writing - Đề Thực Chiến Số 01',
                'description' => 'Trọn bộ đề thi Nói & Viết chuẩn format IIG/ETS với trình ghi âm trực tiếp và công cụ gõ bài luận.',
                'duration_minutes' => 80,
                'is_published' => true,
            ]
        );

        // Speaking Question 1: Read a text aloud
        MockQuestionSW::updateOrCreate(
            ['mock_exam_s_w_id' => $exam->id, 'question_number' => 1, 'skill' => 'speaking'],
            [
                'task_type' => 'Question 1: Read a Text Aloud',
                'prompt' => 'Welcome to the annual Green City Expo. Today, you will have the opportunity to explore cutting-edge solar panels, electric vehicles, and sustainable home appliances. Please make sure to keep your visitor badges visible at all times.',
                'image_url' => null,
                'audio_url' => null,
                'prep_time_seconds' => 45,
                'response_time_seconds' => 45,
                'min_words' => null,
                'sample_answer' => 'Chú ý ngắt nhịp đúng tại các dấu phẩy: solar panels [ngắt], electric vehicles [ngắt], and sustainable home appliances. Phát âm rõ ràng đuôi /z/ ở badges và appliances.'
            ]
        );

        // Speaking Question 2: Describe a picture
        MockQuestionSW::updateOrCreate(
            ['mock_exam_s_w_id' => $exam->id, 'question_number' => 3, 'skill' => 'speaking'],
            [
                'task_type' => 'Question 3: Describe a Picture',
                'prompt' => 'Describe what you see in the picture as in detail as possible.',
                'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60',
                'audio_url' => null,
                'prep_time_seconds' => 45,
                'response_time_seconds' => 30,
                'min_words' => null,
                'sample_answer' => 'This picture shows a modern office setting where three coworkers are gathered around a table, analyzing information displayed on an open laptop...'
            ]
        );

        // Writing Question 1: Write a sentence based on a picture
        MockQuestionSW::updateOrCreate(
            ['mock_exam_s_w_id' => $exam->id, 'question_number' => 1, 'skill' => 'writing'],
            [
                'task_type' => 'Question 1: Write a Sentence Based on a Picture',
                'prompt' => 'Từ khóa bắt buộc: [colleague / discuss]. Viết 01 câu hoàn chỉnh sử dụng 2 từ khóa này mô tả bức ảnh.',
                'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60',
                'audio_url' => null,
                'prep_time_seconds' => 0,
                'response_time_seconds' => 480, // 8 phút
                'min_words' => null,
                'sample_answer' => 'The colleagues are discussing the project updates while looking at the computer.'
            ]
        );

        // Writing Question 8: Write an opinion essay
        MockQuestionSW::updateOrCreate(
            ['mock_exam_s_w_id' => $exam->id, 'question_number' => 8, 'skill' => 'writing'],
            [
                'task_type' => 'Question 8: Write an Opinion Essay',
                'prompt' => 'Do you agree or disagree with the following statement? "Working remotely from home is more productive than working in a traditional corporate office." Give specific reasons and examples to support your view.',
                'image_url' => null,
                'audio_url' => null,
                'prep_time_seconds' => 0,
                'response_time_seconds' => 1800, // 30 phút
                'min_words' => 300,
                'sample_answer' => 'Essay outline: 1. Introduction (hook + thesis statement), 2. Body 1 (Elimination of daily commute saves time and energy), 3. Body 2 (Flexible working environment improves work-life balance), 4. Conclusion.'
            ]
        );
    }
}