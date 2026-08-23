<?php

namespace Database\Seeders;

use App\Models\WritingTask;
use Illuminate\Database\Seeder;

class WritingTaskSeeder extends Seeder
{
    public function run(): void
    {
        // Part 1: Viết câu theo tranh
        WritingTask::updateOrCreate(
            ['slug' => 'part-1-viet-cau-tranh-hoi-thao'],
            [
                'title' => 'Part 1: Viết câu mô tả sự kiện hội thảo',
                'part' => 'part_1',
                'prompt' => 'Viết 01 câu hoàn chỉnh sử dụng đúng dạng ngữ pháp của 2 từ khóa cho trước để mô tả bức ảnh bên dưới.',
                'keywords' => 'present / audience',
                'image_url' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=60',
                'time_limit_minutes' => 5,
                'min_words' => 5,
                'sample_response' => 'The speaker is presenting important project updates to the attentive audience in the conference room.',
                'key_vocabulary' => 'present to someone, engaged audience, conference room, deliver a speech',
            ]
        );

        // Part 2: Trả lời Email
        WritingTask::updateOrCreate(
            ['slug' => 'part-2-hoi-dap-email-khieu-nai'],
            [
                'title' => 'Part 2: Phản hồi Email khách hàng phàn nàn về dịch vụ',
                'part' => 'part_2',
                'prompt' => "From: David Miller <david@client.com>\nSubject: Shipment Delay Inquiry\n\nDear Customer Support,\nI ordered office furniture on March 1st (Order #4928), but it has not arrived yet. Could you please give me an update on the delivery schedule and explain why there is a delay?\n\n--- Hướng dẫn: Viết thư phản hồi xin lỗi vì sự bất tiện, đưa ra ngày giao hàng dự kiến và đề xuất chính sách bồi hoàn/giảm giá.",
                'keywords' => null,
                'image_url' => null,
                'time_limit_minutes' => 10,
                'min_words' => 70,
                'sample_response' => "Dear Mr. Miller,\n\nThank you for reaching out to us. We sincerely apologize for the delay regarding your Order #4928.\n\nDue to unexpected logistics disruptions, your furniture shipment was temporarily held at our central warehouse. We are pleased to inform you that your order has been dispatched today and is scheduled for delivery on Monday, March 10th.\n\nTo compensate for this inconvenience, we would like to offer you a 15% discount coupon for your next purchase.\n\nSincerely,\nCustomer Support Team",
                'key_vocabulary' => 'sincerely apologize for, logistics disruption, be dispatched, compensate for inconvenience',
            ]
        );

        // Part 3: Bài luận
        WritingTask::updateOrCreate(
            ['slug' => 'part-3-bai-luan-lam-viec-tu-xa'],
            [
                'title' => 'Part 3: Bài luận về mô hình làm việc từ xa (Remote Work)',
                'part' => 'part_3',
                'prompt' => 'Do you agree or disagree with the following statement? "Working remotely from home improves employees\' productivity more than working in an office." Support your point of view with reasons and examples from your experience.',
                'keywords' => null,
                'image_url' => null,
                'time_limit_minutes' => 30,
                'min_words' => 300,
                'sample_response' => 'In recent years, remote working has emerged as a prominent work model worldwide. In my opinion, I strongly agree that working from home substantially boosts employee productivity due to reduced commuting stress and higher workplace flexibility...',
                'key_vocabulary' => 'boost employee productivity, eliminate daily commute, work-life balance, self-discipline',
            ]
        );
    }
}