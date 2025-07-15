<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
class TopicListApiController extends Controller
{
    // API nhận student_id để lấy danh sách tất cả các topic trong khóa học và trả về json cho client
    public function getTopicList(Request $request, $studentId)
    {
        try {
            // Kiểm tra student_id có hợp lệ không
            if (empty($studentId)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Student ID is required.'
                ], 400);
            }

            // Lấy danh sách tất cả các topic trong khóa học từ cơ sở dữ liệu
            $topics = Topic::leftJoin('word', 'topic.topic_id', '=', 'word.topic_id')
                ->leftJoin('student_word_record', function ($join) use ($studentId) {
                    $join->on('word.word_id', '=', 'student_word_record.word_id')
                        ->where('student_word_record.student_id', $studentId)
                        ->where('student_word_record.is_mastered', true);
                })
                ->select('topic.topic_id', 'topic.name', 'topic.number_of_word', 'topic.level',
                    DB::raw('COUNT(student_word_record.word_id) as learned_words_count'))
                ->groupBy('topic.topic_id', 'topic.name', 'topic.number_of_word', 'topic.level')
                ->get();

            // Lấy is_completed của topic trong bảng student_topic_record
            $topics = $topics->map(function ($topic) use ($studentId) {
                $isCompleted = DB::table('student_topic_record')
                    ->where('student_id', $studentId)
                    ->where('topic_id', $topic->topic_id)
                    ->value('is_completed');

                // Nếu không có record thì is_completed = false, nếu có thì lấy giá trị từ DB
                $topic->is_completed = $isCompleted ? (bool)$isCompleted : false;

                return $topic;
            });

            // Đếm các từ đã học trong mỗi topic
            $topics = $topics->map(function ($topic) use ($studentId) {
                $learnedWordsCount = DB::table('student_word_record')
                    ->join('word', 'student_word_record.word_id', '=', 'word.word_id')
                    ->where('student_word_record.student_id', $studentId)
                    ->where('word.topic_id', $topic->topic_id)
                    ->where('student_word_record.is_learned', true)
                    ->count();
                $topic->learned_words_count = $learnedWordsCount;
                return $topic;
            });

            // Kiểm tra xem học sinh đã bắt đầu học topic chưa. Nếu number_of_word > 0 thì hasStartedLearn = true, ngược lại false
            $topics = $topics->map(function ($topic) {
                $topic->hasStartedLearn = $topic->learned_words_count > 0;
                return $topic;
            });
            // Trả về danh sách topic dưới dạng JSON
            return response()->json($topics->map(function ($topic) {
                    return [
                        'id' => $topic->topic_id,
                        'name' => $topic->name,
                        'numberOfWord' => $topic->number_of_word,
                        'numberOfLearnedWord' => $topic->learned_words_count,
                        'isCompleted' => $topic->is_completed,
                        'hasStartedLearn' => $topic->hasStartedLearn
                    ];
                }), 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching topics: ' . $e->getMessage()
            ], 500);
        }
    }
}
