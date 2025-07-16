<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentWordRecord;
class StudentWordRecordApiController extends Controller
{
    //Trả lại bảng student_word_record cho client
    public function getMyWordRecord(Request $request, $userID){
        try {
            // Kiểm tra userID có hợp lệ không
            if (empty($userID)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User ID is required.'
                ], 400);
            }

            // Lấy danh sách bản ghi từ của học sinh từ cơ sở dữ liệu
            $studentWordRecords = StudentWordRecord::where('student_id', $userID)->join('word', 'student_word_record.word_id', '=', 'word.word_id')->select(
                'student_word_record.word_id as id',
                'word.word as word',
                'word.meaning as description',
                'word.score as score',
                'student_word_record.is_learned as isLearned',
                'student_word_record.replay_time as replayTimes',
                'student_word_record.is_mastered as isMastered'
            )->get();

            $studentWordRecords = $studentWordRecords->map(function ($record) {
                $record->isLearned = (bool) $record->isLearned;
                $record->isMastered = (bool) $record->isMastered;
                return $record;
            });
            // Trả về danh sách bản ghi từ dưới dạng JSON
            return response()->json(
                $studentWordRecords, 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
