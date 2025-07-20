<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentWordRecord;
use App\Models\StudentProgress;
use Exception;

class UpdateWordApiController extends Controller
{
    public function updateWord(Request $request, $userID)
    {
        try {
            // Nhận file json từ client
            $data = $request->json()->all();

            if (empty($data) || !isset($data['words']) || empty($data['words'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No word data received'
                ], 400);
            }

            DB::beginTransaction();
            $wordScore = $data['score'] ?? 0; // Tổng điểm từ JSON
            $updatedRecords = [];
            $totalScoreIncrement = 0; // Điểm tăng thêm từ JSON
            $masteredWords = 0;
            $learnedWords = 0;
            $topicStats = []; // Thống kê theo topic

            // Xử lý từng word record
            foreach ($data['words'] as $wordData) {
                $wordId = $wordData['id'];
                $score = $wordData['score'] ?? 0;
                $isLearned = $wordData['isLearned'] ?? false;
                $replayTimes = $wordData['replayTimes'] ?? 0;
                $isMastered = $wordData['isMastered'] ?? false;

                // Lấy thông tin topic cho từng từ
                $wordInfo = DB::table('word')
                    ->where('word_id', $wordId)
                    ->first(['topic_id']);

                if (!$wordInfo) {
                    continue; // Bỏ qua nếu không tìm thấy word
                }

                $topicId = $wordInfo->topic_id;

                // Khởi tạo topic stats nếu chưa có
                if (!isset($topicStats[$topicId])) {
                    $topicStats[$topicId] = [
                        'mastered_words' => 0,
                        'learned_words' => 0,
                        'total_words' => DB::table('word')->where('topic_id', $topicId)->count()
                    ];
                }

                // Tìm hoặc tạo student word record
                $existingRecord = StudentWordRecord::where([
                    'student_id' => $userID,
                    'word_id' => $wordId
                ])->first();

                if ($existingRecord) {
                    // Update existing record
                    $existingRecord->update([
                        'score' => $score,
                        'is_learned' => $isLearned,
                        'replay_time' => $replayTimes,
                        'is_mastered' => $isMastered,
                        'updated_at' => now()
                    ]);
                    $wordRecord = $existingRecord;
                } else {
                    // Create new record with generated ID
                    $recordId = 'swr_' . $userID . '_' . $wordId . '_' . time();
                    $wordRecord = StudentWordRecord::create([
                        'student_word_record_id' => $recordId,
                        'student_id' => $userID,
                        'word_id' => $wordId,
                        'score' => $score,
                        'is_learned' => $isLearned,
                        'replay_time' => $replayTimes,
                        'is_mastered' => $isMastered,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                $updatedRecords[] = $wordRecord;

                // Tính điểm tăng thêm
                $totalScoreIncrement += $score;

                // Đếm số từ đã học và đã thành thạo
                if ($isLearned) {
                    $learnedWords++;
                    $topicStats[$topicId]['learned_words']++;
                }
                if ($isMastered) {
                    $masteredWords++;
                    $topicStats[$topicId]['mastered_words']++;
                }
            }

            // Cập nhật student_topic_record cho từng topic
            foreach ($topicStats as $topicId => $stats) {
                $totalWordsInTopic = $stats['total_words'];
                $totalMasteredInTopic = DB::table('student_word_record')
                    ->join('word', 'student_word_record.word_id', '=', 'word.word_id')
                    ->where('student_word_record.student_id', $userID)
                    ->where('word.topic_id', $topicId)
                    ->where('student_word_record.is_mastered', true)
                    ->count();

                DB::table('student_topic_record')->updateOrInsert(
                    [
                        'student_id' => $userID,
                        'topic_id' => $topicId
                    ],
                    [
                        'current_word' => $totalMasteredInTopic,
                        'is_completed' => $totalMasteredInTopic >= $totalWordsInTopic,
                        'updated_at' => now()
                    ]
                );
            }

            // Lấy total_score cũ và cộng với điểm tăng thêm
            $studentProgress = StudentProgress::firstOrNew(['student_id' => $userID]);
            $oldTotalScore = $studentProgress->total_score ?? 0;
            $newTotalScore = $oldTotalScore + $totalScoreIncrement;

            // Cập nhật level dựa trên hoàn thành topic
            $currentLevel = $studentProgress->level ?? 1;
            $nextLevelTopics = DB::table('topic')
                ->where('level', $currentLevel)
                ->get(['topic_id', 'number_of_word']);

            $allMastered = true;
            foreach ($nextLevelTopics as $topic) {
                $masteredCount = DB::table('student_topic_record')
                    ->where('student_id', $userID)
                    ->where('topic_id', $topic->topic_id)
                    ->where('current_word', $topic->number_of_word)
                    ->where('is_completed', true)
                    ->count();
                if ($masteredCount == 0) {
                    $allMastered = false;
                    break;
                }
            }
            $newLevel = $allMastered ? min($currentLevel + 1, 10) : $currentLevel;

            // Update student_progress
            $studentProgress->update([
                'level' => $newLevel,
                'total_score' => $newTotalScore,
                'word_score' => $wordScore, // Gán score từ JSON vào word_score
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Words updated successfully',
                'data' => [
                    'updated_records' => count($updatedRecords),
                    'total_score_increment' => $totalScoreIncrement,
                    'learned_words' => $learnedWords,
                    'mastered_words' => $masteredWords,
                    'student_total_score' => $newTotalScore,
                    'new_level' => $newLevel,
                    'updated_topics' => count($topicStats),
                    'topic_details' => $topicStats
                ]
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
