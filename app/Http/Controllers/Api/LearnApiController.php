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

            $studyCandidates = [];
            $practiseCandidates = [];

            foreach ($words as $word) {
                $wordRecord = StudentWordRecord::where('student_id', $studentId)
                    ->where('word_id', $word->word_id)
                    ->first();

                if ($wordRecord) {
                    if (!$wordRecord->is_mastered) {
                        $practiseCandidates[] = [
                            'word_id' => $word->word_id,
                            'word' => $word->word,
                            'meaning' => $word->meaning,
                            'video_url' => $word->video_url,
                            'replay_time' => $wordRecord->replay_time ?? 0,
                        ];
                    }
                } else {
                    $studyCandidates[] = [
                        'word_id' => $word->word_id,
                        'word' => $word->word,
                        'meaning' => $word->meaning,
                        'video_url' => $word->video_url,
                    ];
                }
            }

            // Xác định số lượng dựa trên practiseCandidates
            $practiseCount = count($practiseCandidates);
            $studyCount = 4;
            $practise1Count = 2;
            $practise2Count = 2;

            if ($practiseCount >= 3) {
                $studyCount = 2;
                $practise1Count = 3;
                $practise2Count = 3;
            } elseif ($practiseCount >= 2 && $practiseCount < 3) {
                $studyCount = 4;
                $practise1Count = 2;
                $practise2Count = 2;
            } elseif ($practiseCount == 1) {
                $studyCount = 4;
                $practise1Count = 2;
                $practise2Count = 2;
            } elseif ($practiseCount == 0) {
                $studyCount = 4;
                $practise1Count = 2;
                $practise2Count = 2;
            }

            // Lấy ngẫu nhiên các chỉ số cho study
            $allIndices = array_keys($studyCandidates);
            $studyIndices = $studyCount > 0 && !empty($studyCandidates) ? array_rand($allIndices, $studyCount) : [];
            if (!is_array($studyIndices)) $studyIndices = [$studyIndices];
            $remainingIndices = array_diff($allIndices, $studyIndices);

            // Lấy ngẫu nhiên các chỉ số cho practise1 và practise2 từ practiseCandidates
            $practise1Indices = $practise1Count > 0 && !empty($practiseCandidates) ? array_rand($practiseCandidates, min($practise1Count, count($practiseCandidates))) : [];
            if (!is_array($practise1Indices)) $practise1Indices = [$practise1Indices];
            $practise2Indices = $practise2Count > 0 && !empty($practiseCandidates) ? array_rand(array_diff_key($practiseCandidates, array_flip($practise1Indices)), min($practise2Count, count($practiseCandidates) - count($practise1Indices))) : [];
            if (!is_array($practise2Indices)) $practise2Indices = [$practise2Indices];

            // Bổ sung practise từ studyCandidates nếu cần
            $additionalPractise1Count = max(0, $practise1Count - count($practise1Indices));
            $additionalPractise2Count = max(0, $practise2Count - count($practise2Indices));

            if ($additionalPractise1Count > 0 || $additionalPractise2Count > 0) {
                $availableIndices = array_values($remainingIndices);
                $additionalIndices = $additionalPractise1Count + $additionalPractise2Count > 0 && !empty($availableIndices) ? array_rand($availableIndices, min($additionalPractise1Count + $additionalPractise2Count, count($availableIndices))) : [];
                if (!is_array($additionalIndices)) $additionalIndices = [$additionalIndices];

                for ($i = 0; $i < $additionalPractise1Count && $i < count($additionalIndices); $i++) {
                    $index = $availableIndices[$additionalIndices[$i]];
                    $practise1[] = $this->createPractise1($studyCandidates[$index], $studyCandidates);
                }
                for ($i = $additionalPractise1Count; $i < $additionalPractise1Count + $additionalPractise2Count && $i < count($additionalIndices); $i++) {
                    $index = $availableIndices[$additionalIndices[$i]];
                    $practise2[] = $this->createPractise2($studyCandidates[$index], $studyCandidates);
                }
            }

            // Xử lý study
            $study = [];
            foreach ($studyIndices as $index) {
                $word = $studyCandidates[$index];
                $study[] = [
                    'type' => 'study',
                    'mainContent' => $word['video_url'],
                    'word' => [
                        'id' => $word['word_id'],
                        'word' => $word['word'],
                        'description' => $word['meaning'],
                        'score' => 0,
                        'isLearned' => false,
                        'replayTimes' => 0,
                        'isMastered' => false,
                    ],
                    'answers' => null,
                    'correctAnswer' => null,
                ];
            }

            // Xử lý practise1 từ practiseCandidates
            foreach ($practise1Indices as $index) {
                $word = $practiseCandidates[$index];
                $availableAnswers = array_diff(array_column($studyCandidates, 'word'), [$word['word']]);
                $answers1 = array_merge([$word['word']], array_slice($availableAnswers, 0, 3));
                shuffle($answers1);

                $practise1[] = [
                    'type' => 'practise1',
                    'mainContent' => $word['video_url'],
                    'word' => [
                        'id' => $word['word_id'],
                        'word' => $word['word'],
                        'description' => $word['meaning'],
                        'isLearned' => true,
                        'replayTimes' => $word['replay_time'],
                        'isMastered' => false,
                    ],
                    'answers' => $answers1,
                    'correctAnswer' => $word['word'],
                ];
            }

            // Xử lý practise2 từ practiseCandidates
            foreach ($practise2Indices as $index) {
                $word = $practiseCandidates[$index];
                $wordParts = explode(' ', trim($word['word']));
                $availableAnswers = array_diff(array_column($studyCandidates, 'word'), [$word['word']]);
                $answers2 = array_merge($wordParts, array_slice($availableAnswers, 0, max(0, 5 - count($wordParts))));

                if (count($answers2) < 5) {
                    $answers2 = array_pad($answers2, 5, $word['word']);
                }
                $answers2 = array_slice(array_unique($answers2), 0, 6);
                shuffle($answers2);

                $practise2[] = [
                    'type' => 'practise2',
                    'mainContent' => $word['video_url'],
                    'word' => [
                        'id' => $word['word_id'],
                        'word' => $word['word'],
                        'description' => $word['meaning'],
                        'isLearned' => true,
                        'replayTimes' => $word['replay_time'],
                        'isMastered' => false,
                    ],
                    'answers' => $answers2,
                    'correctAnswer' => $word['word'],
                ];
            }
        };

        // Hàm tạo practise1
        private function createPractise1($word, $studyCandidates) {
            $availableAnswers = array_diff(array_column($studyCandidates, 'word'), [$word['word']]);
            $answers1 = array_merge([$word['word']], array_slice($availableAnswers, 0, 3));
            shuffle($answers1);

            return [
                'type' => 'practise1',
                'mainContent' => $word['video_url'],
                'word' => [
                    'id' => $word['word_id'],
                    'word' => $word['word'],
                    'description' => $word['meaning'],
                    'isLearned' => false,
                    'replayTimes' => 0,
                    'isMastered' => false,
                ],
                'answers' => $answers1,
                'correctAnswer' => $word['word'],
            ];
        }

        // Hàm tạo practise2
        private function createPractise2($word, $studyCandidates) {
            $wordParts = explode(' ', trim($word['word']));
            $availableAnswers = array_diff(array_column($studyCandidates, 'word'), [$word['word']]);
            $answers2 = array_merge($wordParts, array_slice($availableAnswers, 0, max(0, 5 - count($wordParts))));

            if (count($answers2) < 5) {
                $answers2 = array_pad($answers2, 5, $word['word']);
            }
            $answers2 = array_slice(array_unique($answers2), 0, 6);
            shuffle($answers2);

            return [
                'type' => 'practise2',
                'mainContent' => $word['video_url'],
                'word' => [
                    'id' => $word['word_id'],
                    'word' => $word['word'],
                    'description' => $word['meaning'],
                    'isLearned' => false,
                    'replayTimes' => 0,
                    'isMastered' => false,
                ],
                'answers' => $answers2,
                'correctAnswer' => $word['word'],
            ];
        }

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
