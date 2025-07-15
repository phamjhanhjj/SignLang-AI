<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LearnVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $learnVideos = [
            // Videos cho alphabet (topic_1) - 29 chữ cái
            ['learn_video_id' => 'learn_video_1', 'word_id' => 'word_1', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/a.mp4', 'created_at' => now(), 'updated_at' => now()], // word: a
            ['learn_video_id' => 'learn_video_2', 'word_id' => 'word_2', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/a%CC%86.mp4', 'created_at' => now(), 'updated_at' => now()], // word: ă
            ['learn_video_id' => 'learn_video_3', 'word_id' => 'word_3', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/a%CC%82.mp4', 'created_at' => now(), 'updated_at' => now()], // word: â
            ['learn_video_id' => 'learn_video_4', 'word_id' => 'word_4', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/b.mp4', 'created_at' => now(), 'updated_at' => now()], // word: b
            ['learn_video_id' => 'learn_video_5', 'word_id' => 'word_5', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/c.mp4', 'created_at' => now(), 'updated_at' => now()], // word: c
            ['learn_video_id' => 'learn_video_6', 'word_id' => 'word_6', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/d.mp4', 'created_at' => now(), 'updated_at' => now()], // word: d
            ['learn_video_id' => 'learn_video_7', 'word_id' => 'word_7', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/%C4%91.mp4', 'created_at' => now(), 'updated_at' => now()], // word: đ
            ['learn_video_id' => 'learn_video_8', 'word_id' => 'word_8', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/e.mp4', 'created_at' => now(), 'updated_at' => now()], // word: e
            ['learn_video_id' => 'learn_video_9', 'word_id' => 'word_9', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/e%CC%82.mp4', 'created_at' => now(), 'updated_at' => now()], // word: ê
            ['learn_video_id' => 'learn_video_10', 'word_id' => 'word_10', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/g.mp4', 'created_at' => now(), 'updated_at' => now()], // word: g
            ['learn_video_id' => 'learn_video_11', 'word_id' => 'word_11', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/h.mp4', 'created_at' => now(), 'updated_at' => now()], // word: h
            ['learn_video_id' => 'learn_video_12', 'word_id' => 'word_12', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/i.mp4', 'created_at' => now(), 'updated_at' => now()], // word: i
            ['learn_video_id' => 'learn_video_13', 'word_id' => 'word_13', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/k.mp4', 'created_at' => now(), 'updated_at' => now()], // word: k
            ['learn_video_id' => 'learn_video_14', 'word_id' => 'word_14', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/l.mp4', 'created_at' => now(), 'updated_at' => now()], // word: l
            ['learn_video_id' => 'learn_video_15', 'word_id' => 'word_15', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/m.mp4', 'created_at' => now(), 'updated_at' => now()], // word: m
            ['learn_video_id' => 'learn_video_16', 'word_id' => 'word_16', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/n.mp4', 'created_at' => now(), 'updated_at' => now()], // word: n
            ['learn_video_id' => 'learn_video_17', 'word_id' => 'word_17', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/o.mp4', 'created_at' => now(), 'updated_at' => now()], // word: o
            ['learn_video_id' => 'learn_video_18', 'word_id' => 'word_18', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/o%CC%82.mp4', 'created_at' => now(), 'updated_at' => now()], // word: ô
            ['learn_video_id' => 'learn_video_19', 'word_id' => 'word_19', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/o%CC%9B.mp4', 'created_at' => now(), 'updated_at' => now()], // word: ơ
            ['learn_video_id' => 'learn_video_20', 'word_id' => 'word_20', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/p.mp4', 'created_at' => now(), 'updated_at' => now()], // word: p
            ['learn_video_id' => 'learn_video_21', 'word_id' => 'word_21', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/q.mp4', 'created_at' => now(), 'updated_at' => now()], // word: q
            ['learn_video_id' => 'learn_video_22', 'word_id' => 'word_22', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/r.mp4', 'created_at' => now(), 'updated_at' => now()], // word: r
            ['learn_video_id' => 'learn_video_23', 'word_id' => 'word_23', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/s.mp4', 'created_at' => now(), 'updated_at' => now()], // word: s
            ['learn_video_id' => 'learn_video_24', 'word_id' => 'word_24', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/t.mp4', 'created_at' => now(), 'updated_at' => now()], // word: t
            ['learn_video_id' => 'learn_video_25', 'word_id' => 'word_25', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/u.mp4', 'created_at' => now(), 'updated_at' => now()], // word: u
            ['learn_video_id' => 'learn_video_26', 'word_id' => 'word_26', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/u%CC%9B.mp4', 'created_at' => now(), 'updated_at' => now()], // word: ư
            ['learn_video_id' => 'learn_video_27', 'word_id' => 'word_27', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/v.mp4', 'created_at' => now(), 'updated_at' => now()], // word: v
            ['learn_video_id' => 'learn_video_28', 'word_id' => 'word_28', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/x.mp4', 'created_at' => now(), 'updated_at' => now()], // word: x
            ['learn_video_id' => 'learn_video_29', 'word_id' => 'word_29', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/B%E1%BA%A3ng+ch%E1%BB%AF+c%C3%A1i/y.mp4', 'created_at' => now(), 'updated_at' => now()], // word: y

            // Videos cho numbers (topic_2) - 22 số
            ['learn_video_id' => 'learn_video_30', 'word_id' => 'word_30', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/1.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 1
            ['learn_video_id' => 'learn_video_31', 'word_id' => 'word_31', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/2.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 2
            ['learn_video_id' => 'learn_video_32', 'word_id' => 'word_32', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/3.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 3
            ['learn_video_id' => 'learn_video_33', 'word_id' => 'word_33', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/4.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 4
            ['learn_video_id' => 'learn_video_34', 'word_id' => 'word_34', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/5.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 5
            ['learn_video_id' => 'learn_video_35', 'word_id' => 'word_35', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/6.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 6
            ['learn_video_id' => 'learn_video_36', 'word_id' => 'word_36', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/7.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 7
            ['learn_video_id' => 'learn_video_37', 'word_id' => 'word_37', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/8.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 8
            ['learn_video_id' => 'learn_video_38', 'word_id' => 'word_38', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/9.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 9
            ['learn_video_id' => 'learn_video_39', 'word_id' => 'word_39', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/10.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 10
            ['learn_video_id' => 'learn_video_40', 'word_id' => 'word_40', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/11.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 11
            ['learn_video_id' => 'learn_video_41', 'word_id' => 'word_41', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/12.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 12
            ['learn_video_id' => 'learn_video_42', 'word_id' => 'word_42', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/23.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 23
            ['learn_video_id' => 'learn_video_43', 'word_id' => 'word_43', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/40.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 40
            ['learn_video_id' => 'learn_video_44', 'word_id' => 'word_44', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/80.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 80
            ['learn_video_id' => 'learn_video_45', 'word_id' => 'word_45', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/90.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 90
            ['learn_video_id' => 'learn_video_46', 'word_id' => 'word_46', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/100.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 100
            ['learn_video_id' => 'learn_video_47', 'word_id' => 'word_47', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/1000.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 1000
            ['learn_video_id' => 'learn_video_48', 'word_id' => 'word_48', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/m%E1%BB%99t+t%E1%BB%89.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 1 000 000 000
            ['learn_video_id' => 'learn_video_49', 'word_id' => 'word_49', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/m%E1%BB%99t+tri%E1%BB%87u.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 1 000 000
            ['learn_video_id' => 'learn_video_50', 'word_id' => 'word_50', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/m%C6%B0%E1%BB%9Di+ngh%C3%ACn.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 10 000
            ['learn_video_id' => 'learn_video_51', 'word_id' => 'word_51', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/S%E1%BB%91+trong+ti%E1%BA%BFng+vi%E1%BB%87t/n%C4%83m+ngh%C3%ACn.mp4', 'created_at' => now(), 'updated_at' => now()], // word: 5 000

            // Videos cho diacritics (topic_3) - 5 dấu thanh
            ['learn_video_id' => 'learn_video_52', 'word_id' => 'word_52', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/D%E1%BA%A5u+ti%E1%BA%BFng+vi%E1%BB%87t/huy%E1%BB%81n.mp4', 'created_at' => now(), 'updated_at' => now()], // word: huyền
            ['learn_video_id' => 'learn_video_53', 'word_id' => 'word_53', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/D%E1%BA%A5u+ti%E1%BA%BFng+vi%E1%BB%87t/s%E1%BA%AFc.mp4', 'created_at' => now(), 'updated_at' => now()], // word: sắc
            ['learn_video_id' => 'learn_video_54', 'word_id' => 'word_54', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/D%E1%BA%A5u+ti%E1%BA%BFng+vi%E1%BB%87t/h%E1%BB%8Fi.mp4', 'created_at' => now(), 'updated_at' => now()], // word: hỏi
            ['learn_video_id' => 'learn_video_55', 'word_id' => 'word_55', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/D%E1%BA%A5u+ti%E1%BA%BFng+vi%E1%BB%87t/ng%C3%A3.mp4', 'created_at' => now(), 'updated_at' => now()], // word: ngã
            ['learn_video_id' => 'learn_video_56', 'word_id' => 'word_56', 'video_url' => 'https://sign-language-application-bucket.s3.ap-southeast-2.amazonaws.com/D%E1%BA%A5u+ti%E1%BA%BFng+vi%E1%BB%87t/n%E1%BA%B7ng.mp4', 'created_at' => now(), 'updated_at' => now()], // word: nặng
        ];

        // Chèn dữ liệu vào bảng learn_videos
        DB::table('learn_videos')->insert($learnVideos);
    }
}
