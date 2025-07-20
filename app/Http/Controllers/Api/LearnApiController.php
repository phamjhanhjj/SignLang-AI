<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgress;
use Illuminate\Support\Facades\DB;
use App\Models\StudentWordRecord;

class LearnApiController extends Controller
{
    public function getlearn(Request $request, $studentId)
    {
        // Kiểm tra request có phải JSON không
        // if (!$request->isJson()) {
        //     return response()->json(['error' => 'Invalid request format, JSON expected'], 400);
        // }

        // Xử lý dữ liệu JSON
        // $data = $request->json()->all();
        // $studentId = $data['student_id'] ?? null;

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
        $practise3 = [];

        // Hàm xử lý từ cho một topic
        $processTopicWords = function ($topic, $studentId) use (&$study, &$practise1, &$practise2, &$practise3) {
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

            // Cải tiến logic theo yêu cầu mới
            if ($practiseCount >= 3) {
                // Trường hợp 1: practise >= 3 → 2 study, 3 practise1, 3 practise2
                $studyCount = 2;
                $practise1Count = 3;
                $practise2Count = 3;
            } elseif ($practiseCount == 2) {
                // Trường hợp 2: practise = 2 → 4 study, 2 practise1, 2 practise2
                $studyCount = 4;
                $practise1Count = 2;
                $practise2Count = 2;
            } elseif ($practiseCount == 1) {
                // Trường hợp 3: practise = 1 → 4 study, 2 practise1, 2 practise2
                // (1 practise từ practiseCandidates + 1 từ study)
                $studyCount = 4;
                $practise1Count = 2;
                $practise2Count = 2;
            } else {
                // Trường hợp 4: practise = 0 → 4 study, 2 practise1, 2 practise2
                // (2 practise từ study)
                $studyCount = 4;
                $practise1Count = 2;
                $practise2Count = 2;
            }

            // Lấy ngẫu nhiên các chỉ số cho study
            $allIndices = array_keys($studyCandidates);
            $studyIndices = [];
            if ($studyCount > 0 && !empty($studyCandidates)) {
                $studyIndices = count($allIndices) > 1 ? array_rand($allIndices, min($studyCount, count($allIndices))) : $allIndices;
                if (!is_array($studyIndices)) $studyIndices = [$studyIndices];
            }
            $remainingIndices = array_diff($allIndices, $studyIndices);

            // Lấy ngẫu nhiên các chỉ số cho practise1 và practise2 từ practiseCandidates
            $practise1Indices = [];
            $practise2Indices = [];

            if ($practiseCount >= 3) {
                // Trường hợp 1: practise >= 3 → có thể lấy chung từ practiseCandidates
                // Có thể lấy cả 3 từ cho cả practise1 và practise2
                // Hoặc lấy 2 từ từ practise + 1 từ từ study
                if ($practiseCount >= 6) {
                    // Nếu có đủ 6 từ practise, lấy riêng biệt
                    $practise1Indices = array_rand($practiseCandidates, 3);
                    if (!is_array($practise1Indices)) $practise1Indices = [$practise1Indices];

                    $remaining = array_diff_key($practiseCandidates, array_flip($practise1Indices));
                    $practise2Indices = array_rand($remaining, 3);
                    if (!is_array($practise2Indices)) $practise2Indices = [$practise2Indices];
                } else {
                    // Nếu có 3-5 từ practise, có thể lấy chung hoặc bổ sung từ study
                    $practise1Indices = array_rand($practiseCandidates, min(3, $practiseCount));
                    if (!is_array($practise1Indices)) $practise1Indices = [$practise1Indices];

                    // Cho practise2, có thể lấy chung từ practiseCandidates
                    $practise2Indices = array_rand($practiseCandidates, min(3, $practiseCount));
                    if (!is_array($practise2Indices)) $practise2Indices = [$practise2Indices];
                }
            } elseif ($practiseCount == 2) {
                // Trường hợp 2: practise = 2 → lấy hết 2 từ practiseCandidates
                $practise1Indices = [array_keys($practiseCandidates)[0]];
                $practise2Indices = [array_keys($practiseCandidates)[1]];
            } elseif ($practiseCount == 1) {
                // Trường hợp 3: practise = 1 → lấy 1 từ practiseCandidates
                $practise1Indices = [array_keys($practiseCandidates)[0]];
                // practise2Indices để trống, sẽ bổ sung từ study
            }
            // Trường hợp 4: practise = 0 → cả 2 đều trống, sẽ bổ sung từ study

            // Bổ sung practise từ studyCandidates nếu cần
            $additionalPractise1Count = max(0, $practise1Count - count($practise1Indices));
            $additionalPractise2Count = max(0, $practise2Count - count($practise2Indices));

            if ($additionalPractise1Count > 0 || $additionalPractise2Count > 0) {
                if ($practiseCount >= 3) {
                    // Trường hợp 1: practise >= 3, bổ sung từ study nếu cần
                    $availableForPractise = $studyIndices;

                    // Bổ sung cho practise1 nếu cần
                    for ($i = 0; $i < $additionalPractise1Count && $i < count($availableForPractise); $i++) {
                        $index = $availableForPractise[$i];
                        $practise1[] = $this->createPractise1Helper($studyCandidates[$index], $studyCandidates);
                    }

                    // Bổ sung cho practise2 nếu cần
                    for ($i = 0; $i < $additionalPractise2Count && $i < count($availableForPractise); $i++) {
                        $index = $availableForPractise[$i];
                        $practise2[] = $this->createPractise2Helper($studyCandidates[$index], $studyCandidates);
                    }
                } else {
                    // Trường hợp 2, 3, 4: Lấy practise từ chính 4 từ study
                    $availableForPractise = $studyIndices;

                    // Lấy từ cho practise1 (nếu cần)
                    for ($i = 0; $i < $additionalPractise1Count && $i < count($availableForPractise); $i++) {
                        $index = $availableForPractise[$i];
                        $practise1[] = $this->createPractise1Helper($studyCandidates[$index], $studyCandidates);
                    }

                    // Lấy từ cho practise2 (nếu cần)
                    for ($i = 0; $i < $additionalPractise2Count && ($i + $additionalPractise1Count) < count($availableForPractise); $i++) {
                        $index = $availableForPractise[$i + $additionalPractise1Count];
                        $practise2[] = $this->createPractise2Helper($studyCandidates[$index], $studyCandidates);
                    }
                }
            }

            // Xử lý study
            $studyItems = [];
            foreach ($studyIndices as $index) {
                $word = $studyCandidates[$index];
                $studyItems[] = [
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
                    'answers' => [],
                ];
            }
            $study = array_merge($study, $studyItems);

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
                        'score' => 0,
                        'isLearned' => true,
                        'replayTimes' => $word['replay_time'],
                        'isMastered' => false,
                    ],
                    'answers' => $answers1,
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
                        'score' => 0,
                        'isLearned' => true,
                        'replayTimes' => $word['replay_time'],
                        'isMastered' => false,
                    ],
                    'answers' => $answers2,
                ];
            }

            // Xử lý practise3
            if ($practiseCount > 0) {
                // Nếu có practise candidates, lấy 1 từ bất kỳ
                $practise3Index = array_rand($practiseCandidates, 1);
                $word = $practiseCandidates[$practise3Index];

                $practise3[] = [
                    'type' => 'practise3',
                    'mainContent' => '',
                    'word' => [
                        'id' => $word['word_id'],
                        'word' => $word['word'],
                        'description' => $word['meaning'],
                        'score' => 0,
                        'isLearned' => true,
                        'replayTimes' => $word['replay_time'],
                        'isMastered' => false,
                    ],
                    'answers' => [],
                ];
            } else {
                // Nếu không có practise candidates, lấy 1 từ từ study
                if (!empty($studyIndices)) {
                    $practise3Index = $studyIndices[0]; // Lấy từ đầu tiên trong study
                    $word = $studyCandidates[$practise3Index];

                    $practise3[] = [
                        'type' => 'practise3',
                        'mainContent' => '',
                        'word' => [
                            'id' => $word['word_id'],
                            'word' => $word['word'],
                            'description' => $word['meaning'],
                            'score' => 0,
                            'isLearned' => false,
                            'replayTimes' => 0,
                            'isMastered' => false,
                        ],
                        'answers' => [],
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
        $finalResult = [];

        // Thêm study
        $finalResult = array_merge($finalResult, $study);

        // Thêm practise1
        $finalResult = array_merge($finalResult, $practise1);

        // Thêm practise2
        $finalResult = array_merge($finalResult, $practise2);

        // Thêm practise3 vào đầu
        $finalResult = array_merge($finalResult, $practise3);

        return response()->json($finalResult);
    }

    // Hàm tạo practise1
    private function createPractise1Helper($word, $studyCandidates) {
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
                'score' => 0,
                'isLearned' => false,
                'replayTimes' => 0,
                'isMastered' => false,
            ],
            'answers' => $answers1,
        ];
    }

    // Hàm tạo practise2
    private function createPractise2Helper($word, $studyCandidates) {
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
                'score' => 0,
                'isLearned' => false,
                'replayTimes' => 0,
                'isMastered' => false,
            ],
            'answers' => $answers2,
        ];
    }
}
