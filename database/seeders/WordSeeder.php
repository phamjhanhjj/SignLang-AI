<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alphabet = [
            ['letter' => 'a', 'order' => 'thứ nhất'],
            ['letter' => 'ă', 'order' => 'thứ hai'],
            ['letter' => 'â', 'order' => 'thứ ba'],
            ['letter' => 'b', 'order' => 'thứ tư'],
            ['letter' => 'c', 'order' => 'thứ năm'],
            ['letter' => 'd', 'order' => 'thứ sáu'],
            ['letter' => 'đ', 'order' => 'thứ bảy'],
            ['letter' => 'e', 'order' => 'thứ tám'],
            ['letter' => 'ê', 'order' => 'thứ chín'],
            ['letter' => 'g', 'order' => 'thứ mười'],
            ['letter' => 'h', 'order' => 'thứ mười một'],
            ['letter' => 'i', 'order' => 'thứ mười hai'],
            ['letter' => 'k', 'order' => 'thứ mười ba'],
            ['letter' => 'l', 'order' => 'thứ mười bốn'],
            ['letter' => 'm', 'order' => 'thứ mười lăm'],
            ['letter' => 'n', 'order' => 'thứ mười sáu'],
            ['letter' => 'o', 'order' => 'thứ mười bảy'],
            ['letter' => 'ô', 'order' => 'thứ mười tám'],
            ['letter' => 'ơ', 'order' => 'thứ mười chín'],
            ['letter' => 'p', 'order' => 'thứ hai mươi'],
            ['letter' => 'q', 'order' => 'thứ hai mươi mốt'],
            ['letter' => 'r', 'order' => 'thứ hai mươi hai'],
            ['letter' => 's', 'order' => 'thứ hai mươi ba'],
            ['letter' => 't', 'order' => 'thứ hai mươi bốn'],
            ['letter' => 'u', 'order' => 'thứ hai mươi lăm'],
            ['letter' => 'ư', 'order' => 'thứ hai mươi sáu'],
            ['letter' => 'v', 'order' => 'thứ hai mươi bảy'],
            ['letter' => 'x', 'order' => 'thứ hai mươi tám'],
            ['letter' => 'y', 'order' => 'thứ hai mươi chín'],
        ];

        $words = [];
        foreach ($alphabet as $index => $item) {
            $words[] = [
                'word_id' => 'word_' . ($index + 1),
                'topic_id' => 'topic_1',
                'word' => $item['letter'],
                'meaning' => 'Con chữ ' . $item['order'] . ' trong bảng chữ cái chữ Quốc ngữ.',
                'score' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Thêm các số từ 1-22 cho topic_2 (numbers)
        $numbers = [
            ['number' => '1', 'word_vn' => 'một', 'word_en' => 'one'],
            ['number' => '2', 'word_vn' => 'hai', 'word_en' => 'two'],
            ['number' => '3', 'word_vn' => 'ba', 'word_en' => 'three'],
            ['number' => '4', 'word_vn' => 'bốn', 'word_en' => 'four'],
            ['number' => '5', 'word_vn' => 'năm', 'word_en' => 'five'],
            ['number' => '6', 'word_vn' => 'sáu', 'word_en' => 'six'],
            ['number' => '7', 'word_vn' => 'bảy', 'word_en' => 'seven'],
            ['number' => '8', 'word_vn' => 'tám', 'word_en' => 'eight'],
            ['number' => '9', 'word_vn' => 'chín', 'word_en' => 'nine'],
            ['number' => '10', 'word_vn' => 'mười', 'word_en' => 'ten'],
            ['number' => '11', 'word_vn' => 'mười một', 'word_en' => 'eleven'],
            ['number' => '12', 'word_vn' => 'mười hai', 'word_en' => 'twelve'],
            ['number' => '23', 'word_vn' => 'hai mươi ba', 'word_en' => 'twenty-three'],
            ['number' => '40', 'word_vn' => 'bốn mươi', 'word_en' => 'forty'],
            ['number' => '80', 'word_vn' => 'tám mươi', 'word_en' => 'eighty'],
            ['number' => '90', 'word_vn' => 'chín mươi', 'word_en' => 'ninety'],
            ['number' => '100', 'word_vn' => 'một trăm', 'word_en' => 'one hundred'],
            ['number' => '1000', 'word_vn' => 'một nghìn', 'word_en' => 'one thousand'],
            ['number' => '1 000 000 000', 'word_vn' => 'một tỷ', 'word_en' => 'one billion'],
            ['number' => '1 000 000', 'word_vn' => 'một triệu', 'word_en' => 'one million'],
            ['number' => '10 000', 'word_vn' => 'mười nghìn', 'word_en' => 'ten thousand'],
            ['number' => '5 000', 'word_vn' => 'năm nghìn', 'word_en' => 'five thousand'],
        ];

        foreach ($numbers as $index => $item) {
            $words[] = [
                'word_id' => 'word_' . (30 + $index),
                'topic_id' => 'topic_2',
                'word' => $item['number'],
                'meaning' => 'Số ' . $item['word_vn'] . ' (' . $item['word_en'] . ')',
                'score' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Thêm 5 dấu thanh trong tiếng Việt cho topic_3 (diacritics)
        $diacritics = [
            ['diacritic' => 'huyền', 'example' => 'à', 'description' => 'Dấu huyền - thanh huyền'],
            ['diacritic' => 'sắc', 'example' => 'á', 'description' => 'Dấu sắc - thanh sắc'],
            ['diacritic' => 'hỏi', 'example' => 'ả', 'description' => 'Dấu hỏi - thanh hỏi'],
            ['diacritic' => 'ngã', 'example' => 'ã', 'description' => 'Dấu ngã - thanh ngã'],
            ['diacritic' => 'nặng', 'example' => 'ạ', 'description' => 'Dấu nặng - thanh nặng'],
        ];

        foreach ($diacritics as $index => $item) {
            $words[] = [
                'word_id' => 'word_' . (52 + $index),
                'topic_id' => 'topic_3',
                'word' => $item['diacritic'],
                'meaning' => $item['description'] . ' (ví dụ: ' . $item['example'] . ')',
                'score' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Chèn dữ liệu vào bảng word
        DB::table('word')->insert($words);
    }
}
