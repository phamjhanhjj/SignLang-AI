<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordListApiController extends Controller
{
    // API nhận id(topic_id) và userID(student_id) để lấy danh sách từ trong topic và trả về json cho client
    public function getWordList(Request $request, $id, $userID)
    {
        try {
            // Kiểm tra topic_id và student_id có hợp lệ không
            if (empty($id) || empty($userID)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Topic ID and Student ID are required.'
                ], 400);
            }

            // Lấy danh sách từ trong topic từ cơ sở dữ liệu
            $words = DB::table('word')
                ->where('topic_id', $id)
                ->select('word_id', 'word', 'meaning as description', 'score')
                ->get();

            // Kiểm tra xem học sinh đã học từ nào trong topic chưa, sử dụng bảng student_word_record
            $words = $words->map(function ($word) use ($userID) {
                // Tìm bản ghi trong student_word_record cho từ và học sinh
                $record = DB::table('student_word_record')
                    ->where('student_id', $userID)
                    ->where('word_id', $word->word_id)
                    ->first();

                // Nếu không tìm thấy bản ghi, gán giá trị mặc định
                if (!$record) {
                    $word->isLearned = false;
                    $word->replayTimes = 0;
                    $word->isMastered = false;
                } else {
                    $word->isLearned = true;
                    $word->replayTimes = $record->replay_time ?? 0;
                    $word->isMastered = $record->is_mastered ?? false;
                }

                // Chuẩn hóa dữ liệu để trả về
                return [
                    'id' => $word->word_id,
                    'word' => $word->word,
                    'description' => $word->description,
                    'score' => $word->score,
                    'isLearned' => $word->isLearned,
                    'replayTimes' => $word->replayTimes,
                    'isMastered' => $word->isMastered
                ];
            });

            // Trả về danh sách từ dưới dạng JSON
            return response()->json($words, 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching words: ' . $e->getMessage()
            ], 500);
        }
    }
}
