<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentTopicRecord;
use App\Models\Word;
use App\Models\StudentWordRecord;
class StudentTopicRecordController extends Controller
{
    //Hiển thị danh sách sinh viên đã hoàn thành chủ đề
    public function index()
    {
        $studentTopicRecords = StudentTopicRecord::all();
        return response()->json(['success' => true, 'data' => $studentTopicRecords]);
    }

    //Hiển thị thông tin sinh viên đã hoàn thành chủ đề theo id
    public function show($student_id, $topic_id)
    {
        $studentTopicRecord = StudentTopicRecord::where('student_id', $student_id)
            ->where('topic_id', $topic_id)
            ->first();
        if (!$studentTopicRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi sinh viên cho chủ đề này!']);
        }
        return response()->json(['success' => true, 'data' => $studentTopicRecord]);
    }

    //Thêm bản ghi sinh viên cho chủ đề
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'topic_id' => 'required|exists:topic,topic_id',
            'is_completed' => 'required|boolean',
            'current_word' => 'nullable|integer|min:0', // Cho phép nullable để có thể mặc định
        ]);

        // Đặt current_word mặc định là 0 nếu không được cung cấp
        if (!isset($validated['current_word'])) {
            $validated['current_word'] = 0;
        }

        $studentTopicRecord = StudentTopicRecord::create($validated);
        return response()->json(['success' => true, 'data' => $studentTopicRecord]);
    }

    //Cập nhật bản ghi sinh viên cho chủ đề
    public function update(Request $request, $student_id, $topic_id)
    {
        $studentTopicRecord = StudentTopicRecord::where('student_id', $student_id)->where('topic_id', $topic_id)->first();
        if (!$studentTopicRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi sinh viên cho chủ đề này!']);
        }
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'topic_id' => 'required|exists:topic,topic_id',
            'is_completed' => 'required|boolean',
            'current_word' => 'nullable|integer|min:0', // Cho phép nullable
        ]);

        // Sử dụng query builder thay vì model instance để update
        StudentTopicRecord::where('student_id', $student_id)
            ->where('topic_id', $topic_id)
            ->update($validated);

        // Lấy lại record đã cập nhật để trả về
        $updatedRecord = StudentTopicRecord::where('student_id', $student_id)->where('topic_id', $topic_id)->first();
        return response()->json(['success' => true, 'data' => $updatedRecord]);
    }

    //Xóa bản ghi sinh viên cho chủ đề
    public function destroy($student_id, $topic_id)
    {
        $studentTopicRecord = StudentTopicRecord::where('student_id', $student_id)->where('topic_id', $topic_id)->first();
        if (!$studentTopicRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi sinh viên cho chủ đề này!']);
        }

        // Sử dụng query builder để xóa thay vì model instance
        StudentTopicRecord::where('student_id', $student_id)
            ->where('topic_id', $topic_id)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Bản ghi sinh viên cho chủ đề đã được xóa thành công!']);
    }

    //Tính toán lại current_word cho tất cả các bản ghi
    public function recalculateCurrentWord($studentId, $topicId)
    {
        // Lấy tất cả word_id của topic
        $wordIds = Word::where('topic_id', $topicId)->pluck
        ('word_id');

        // Đếm số từ đã mastered
        $masteredCount = StudentWordRecord::where('student_id', $studentId)
            ->whereIn('word_id', $wordIds)
            ->where('is_mastered', true)
            ->count();

        // Cập nhật current_word
        StudentTopicRecord::where('student_id', $studentId)
            ->where('topic_id', $topicId)
            ->update(['current_word' => $masteredCount]);

        return $masteredCount;
    }
}
