<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'course_id' => 'course_1',
                'nation' => 'Vietnamese',
                'total_topic' => 3, // Tổng số chủ đề trong khóa học
            ]
            ];
        // Chèn dữ liệu vào bảng course
        DB::table('course')->insert($courses);
    }
}
