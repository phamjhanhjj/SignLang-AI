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
            $studentWordRecords = StudentWordRecord::where('student_id', $userID)->select('word_id', 'is_learned', 'replay_time', 'is_mastered')->get();

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
