<?php

namespace Database\Seeders;

use App\Models\VocabularyCategory;
use App\Models\VocabularyWord;
use Illuminate\Database\Seeder;

class VocabularySeeder extends Seeder
{
    public function run(): void
    {
        // Chủ đề 1: Contracts (Hợp đồng)
        $cat1 = VocabularyCategory::updateOrCreate(
            ['slug' => 'contracts-hop-dong'],
            [
                'name' => 'Chủ đề 01: Contracts (Hợp đồng & Đàm phán)',
                'description' => 'Các thuật ngữ cốt lõi xuất hiện liên tục trong Part 5, 6, 7 về điều khoản hợp đồng kinh doanh.',
                'icon' => '📑',
                'order_index' => 1,
            ]
        );

        VocabularyWord::updateOrCreate(
            ['vocabulary_category_id' => $cat1->id, 'word' => 'abide by'],
            [
                'phonetic' => '/əˈbaɪd baɪ/',
                'part_of_speech' => 'v',
                'meaning_vi' => 'Tuân thủ, làm theo',
                'meaning_en' => 'To accept or obey an agreement, rule, or decision.',
                'example_sentence' => 'Both parties must abide by the terms agreed upon in the contract.',
                'example_translation' => 'Cả hai bên phải tuân thủ các điều khoản đã thỏa thuận trong hợp đồng.',
                'image_url' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?w=800&auto=format&fit=crop&q=60',
            ]
        );

        VocabularyWord::updateOrCreate(
            ['vocabulary_category_id' => $cat1->id, 'word' => 'agreement'],
            [
                'phonetic' => '/əˈɡriːmənt/',
                'part_of_speech' => 'n',
                'meaning_vi' => 'Thỏa thuận, hợp đồng',
                'meaning_en' => 'A decision or arrangement, often formal and in writing.',
                'example_sentence' => 'The representatives finally signed a preliminary agreement.',
                'example_translation' => 'Các đại diện cuối cùng đã ký một thỏa thuận sơ bộ.',
                'image_url' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&auto=format&fit=crop&q=60',
            ]
        );

        VocabularyWord::updateOrCreate(
            ['vocabulary_category_id' => $cat1->id, 'word' => 'obligate'],
            [
                'phonetic' => '/ˈɒblɪɡeɪt/',
                'part_of_speech' => 'v',
                'meaning_vi' => 'Bắt buộc, ràng buộc nghĩa vụ',
                'meaning_en' => 'To force someone to do something by law or moral duty.',
                'example_sentence' => 'The contractor is obligated to complete the project by June.',
                'example_translation' => 'Nhà thầu có nghĩa vụ phải hoàn thành dự án trước tháng 6.',
                'image_url' => null,
            ]
        );

        // Chủ đề 2: Marketing & Sales
        $cat2 = VocabularyCategory::updateOrCreate(
            ['slug' => 'marketing-sales'],
            [
                'name' => 'Chủ đề 02: Marketing & Bán Hàng',
                'description' => 'Bộ từ vựng về chiến dịch quảng bá sản phẩm, định vị thị trường và tiếp thị.',
                'icon' => '📈',
                'order_index' => 2,
            ]
        );

        VocabularyWord::updateOrCreate(
            ['vocabulary_category_id' => $cat2->id, 'word' => 'persuade'],
            [
                'phonetic' => '/pəˈsweɪd/',
                'part_of_speech' => 'v',
                'meaning_vi' => 'Thuyết phục',
                'meaning_en' => 'To make someone believe or do something by giving good reasons.',
                'example_sentence' => 'The sales pitch managed to persuade several potential investors.',
                'example_translation' => 'Bài thuyết trình bán hàng đã thuyết phục được nhiều nhà đầu tư tiềm năng.',
                'image_url' => null,
            ]
        );
    }
}