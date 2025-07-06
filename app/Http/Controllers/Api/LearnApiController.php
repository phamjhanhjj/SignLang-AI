<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgress;
use Illuminate\Support\Facades\DB;
use App\Models\StudentWordRecord;

class LearnApiController extends Controller
{
    public function getlearn(Request $request)
    {
        // Kiểm tra request có phải JSON không
        if (!$request->isJson()) {
            return response()->json(['error' => 'Invalid request format, JSON expected'], 400);
        }

        // Xử lý dữ liệu JSON
        $data = $request->json()->all();
        $studentId = $data['student_id'] ?? null;

        // Lấy level của sinh viên từ bảng student_progress
        $studentProgress = StudentProgress::where('student_id', $studentId)->first();
        if (!$studentProgress) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $level = $studentProgress->level;
        $level_next = $level + 1; // Cấp độ tiếp theo

        // Lấy topic duy nhất ở cấp độ hiện tại
        $topic = DB::table('topic')
            ->where('level', $level)
            ->first(['topic_id', 'name', 'level', 'number_of_word']);

        // Lấy topic duy nhất ở cấp độ tiếp theo
        $topic_next = DB::table('topic')
            ->where('level', $level_next)
            ->first(['topic_id', 'name', 'level', 'number_of_word']);

        $result = [];
        $result_next_level = [];
        $study = [];
        $practise1 = [];
        $practise2 = [];

        // Hàm xử lý từ cho một topic
        $processTopicWords = function ($topic, $studentId) use (&$study, &$practise1, &$practise2) {
            if (!$topic) {
                return;
            }

            // Lấy danh sách từ của topic, JOIN với learn_videos để lấy video_url
            $words = DB::table('word')
                ->leftJoin('learn_videos', 'word.word_id', '=', 'learn_videos.word_id')
                ->where('word.topic_id', $topic->topic_id)
                ->get(['word.word_id', 'word.word', 'word.meaning', 'learn_videos.video_url']);

            foreach ($words as $word) {
                $wordRecord = StudentWordRecord::where('student_id', $studentId)
                    ->where('word_id', $word->word_id)
                    ->first();

                if ($wordRecord) {
                    // Nếu từ đã học nhưng chưa thành thạo, thêm vào practise1 và practise2
                    if (!$wordRecord->is_mastered) {
                        // Xử lý practise1
                        // Lấy 3 từ ngẫu nhiên từ bảng word
                        $randomWords = DB::table('word')
                            ->where('word_id', '!=', $word->word_id)
                            ->inRandomOrder()
                            ->take(3)
                            ->pluck('word')
                            ->toArray();

                        // Thêm từ hiện tại vào danh sách answers và xáo trộn
                        $answers1 = array_merge([$word->word], $randomWords);
                        shuffle($answers1);

                        $practise1[] = [
                            'type' => 'practise1',
                            'mainContent' => $word->video_url,
                            'word' => [
                                'id' => $word->word_id,
                                'word' => $word->word,
                                'description' => $word->meaning,
                                'isLearned' => true,
                                'replayTimes' => $wordRecord->replay_time ?? 0,
                                'isMastered' => false,
                            ],
                            'answers' => $answers1,
                            'correctAnswer' => $word->word,
                        ];

                        // Xử lý practise2
                        // Tách từ hiện tại thành các tiếng
                        $wordParts = explode(' ', trim($word->word));
                        $answers2 = $wordParts;

                        // Nếu chưa đủ 5 đáp án, lấy thêm từ ngẫu nhiên và tách thành tiếng
                        if (count($answers2) < 5) {
                            $needed = 5 - count($answers2);
                            $additionalWords = DB::table('word')
                                ->where('word_id', '!=', $word->word_id)
                                ->inRandomOrder()
                                ->take(3)
                                ->pluck('word')
                                ->toArray();

                            foreach ($additionalWords as $additionalWord) {
                                $additionalParts = explode(' ', trim($additionalWord));
                                $answers2 = array_merge($answers2, $additionalParts);
                                if (count($answers2) >= 5) {
                                    break;
                                }
                            }
                            // Cắt để đảm bảo 5-6 đáp án
                            $answers2 = array_slice(array_unique($answers2), 0, 6);
                        }

                        // Xáo trộn answers
                        shuffle($answers2);

                        $practise2[] = [
                            'type' => 'practise2',
                            'mainContent' => $word->video_url,
                            'word' => [
                                'id' => $word->word_id,
                                'word' => $word->word,
                                'description' => $word->meaning,
                                'isLearned' => true,
                                'replayTimes' => $wordRecord->replay_time ?? 0,
                                'isMastered' => false,
                            ],
                            'answers' => $answers2,
                            'correctAnswer' => $word->word,
                        ];
                    }
                } else {
                    // Nếu từ chưa học, thêm vào study
                    $study[] = [
                        'type' => 'study',
                        'mainContent' => $word->video_url,
                        'word' => [
                            'id' => $word->word_id,
                            'word' => $word->word,
                            'description' => $word->meaning,
                            'score' => 0,
                            'isLearned' => false,
                            'replayTimes' => 0,
                            'isMastered' => false,
                        ],
                        'answers' => null,
                        'correctAnswer' => null,
                    ];
                }
            }
        };

        // Xử lý topic ở cấp độ hiện tại
        if ($topic) {
            // Lấy current_word từ student_topic_record
            $currentWord = DB::table('student_topic_record')
                ->where('student_id', $studentId)
                ->where('topic_id', $topic->topic_id)
                ->value('current_word');

            if ($currentWord === null) {
                $currentWord = 0; // Nếu không có bản ghi, coi như chưa học
                // Tạo bản ghi mới
                DB::table('student_topic_record')->insert([
                    'student_id' => $studentId,
                    'topic_id' => $topic->topic_id,
                    'is_completed' => false,
                    'current_word' => 0,
                ]);
            }

            // Tính phần trăm mastered dựa trên current_word
            $percentage = ($topic->number_of_word > 0) ? ($currentWord / $topic->number_of_word) * 100 : 0;

            // Thêm thông tin topic hiện tại vào result
            $result = [
                'topic_id' => $topic->topic_id,
                'name' => $topic->name,
                'level' => $topic->level,
                'number_of_word' => $topic->number_of_word,
                'mastered_words' => $currentWord,
                'percentage' => round($percentage, 2),
            ];

            // Lấy tất cả từ của topic hiện tại
            $processTopicWords($topic, $studentId);

            // Kiểm tra nếu topic hiện tại đạt >= 70% mastered
            if ($percentage >= 70 && $topic_next) {
                // Lấy current_word của topic tiếp theo
                $currentWord_next = DB::table('student_topic_record')
                    ->where('student_id', $studentId)
                    ->where('topic_id', $topic_next->topic_id)
                    ->value('current_word');

                if ($currentWord_next === null) {
                    $currentWord_next = 0; // Nếu không có bản ghi, coi như chưa học
                    // Tạo bản ghi mới
                    DB::table('student_topic_record')->insert([
                        'student_id' => $studentId,
                        'topic_id' => $topic_next->topic_id,
                        'is_completed' => false,
                        'current_word' => 0,
                    ]);
                }

                // Thêm thông tin topic tiếp theo vào result_next_level
                $result_next_level = [
                    'topic_id' => $topic_next->topic_id,
                    'name' => $topic_next->name,
                    'level' => $topic_next->level,
                    'number_of_word' => $topic_next->number_of_word,
                    'mastered_words' => $currentWord_next,
                    'percentage' => ($topic_next->number_of_word > 0) ? ($currentWord_next / $topic_next->number_of_word) * 100 : 0,
                ];

                // Lấy tất cả từ của topic tiếp theo
                $processTopicWords($topic_next, $studentId);
            }
        }

        // Trả về kết quả cho client
        return response()->json([
            'status' => 'success',
            'student_id' => $studentId,
            'level' => $level,
            'topics' => $result ? [$result] : [],
            'next_level' => $result_next_level ? [$result_next_level] : [],
            'study' => $study,
            'practise1' => $practise1,
            'practise2' => $practise2,
        ]);
    }
}
