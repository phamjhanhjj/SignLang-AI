<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            [
                'topic_id' => 'topic_1',
                'course_id' => 'course_1',
                'name' => 'Bảng chữ cái tiếng Việt',
                'level' => 1, // Cấp độ của chủ đề
                'number_of_word' => 29, // Số lượng từ trong chủ đề này
            ],

            [
                'topic_id' => 'topic_2',
                'course_id' =>'course_1',
                'name' => 'Số đếm',
                'level' => 2, // Cấp độ của chủ đề
                'number_of_word' => 22, // Số lượng từ trong chủ đề này
            ],

            [
                'topic_id' => 'topic_3',
                'course_id' => 'course_1',
                'name' => 'Các dấu thanh tiếng Việt',
                'level' => 3, // Cấp độ của chủ đề
                'number_of_word' => 5, // Số lượng từ trong chủ đề này
            ],
        ];
        // Chèn dữ liệu vào bảng topic
        DB::table('topic')->insert($topics);
    }
}
