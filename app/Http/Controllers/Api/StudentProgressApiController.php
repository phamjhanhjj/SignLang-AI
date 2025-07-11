<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgress;
use App\Models\StudentTopicRecord;
use App\Models\StudentWordRecord;

class StudentProgressApiController extends Controller
{
    // API nhận student_id để lấy thông tin tiến độ của học sinh trả về json cho client
    public function getStudentProgress(Request $request, $userid){
        try{
            // Kiểm tra xe userid có hợp lệ không
            if (empty($userid)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'User ID is required.'
                ], 400);
            }

            // Lấy thông tin tiến độ của học sinh từ cơ sở dữ liệu
            $totalScore = StudentProgress::where('student_id', $userid)->sum('total_score');

            $wordScore = StudentProgress::where('student_id', $userid)->sum('word_score');

            $videoScore = 0;
            $practiseScore = 0;

            // Lấy số từ đã mastered và learned
            $masteredWords = StudentWordRecord::where('student_id', $userid)->where('is_mastered', operator: true)->count();

            $learnedWords = StudentWordRecord::where('student_id', $userid)->where('is_learned', true)->where('is_mastered', false)->count();

            $masteredVideos = 0;

            $learnedVideos = 0;


            $masteredConversations = 0;

            $learnedConversations = 0;

            // Lấy tên topic đang học đến từ level trong bảng student topic record
            $currentTopic = StudentTopicRecord::where('student_id', $userid)
                ->where('is_completed', false)
                ->join('topic', 'student_topic_record.topic_id', '=', 'topic.topic_id')
                ->select('topic.name')
                ->first();
            // trả về json cho client
            return response()->json([
                'totalScore' => (int)$totalScore,
                'wordScore' => (int)$wordScore,
                'videoScore' => (int)$videoScore,
                'practiseScore' => (int)$practiseScore,
                'masteredWords' => (int)$masteredWords,
                'learnedWords' => (int)$learnedWords,
                'masteredVideos' => (int)$masteredVideos,
                'learnedVideos' => (int)$learnedVideos,
                'masteredConversations' => (int)$masteredConversations,
                'learnedConversations' => (int)$learnedConversations,
                'currentTopic' => $currentTopic ? $currentTopic->name : null
            ], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi và trả về thông báo lỗi
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching student progress: ' . $e->getMessage()
            ], 500);
        }
    }
}
