<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentTopicRecord;
class StudentTopicRecordController extends Controller
{
    //Hiển thị danh sách sinh viên đã hoàn thành chủ đề
    public function index()
    {
        $studentTopicRecords = StudentTopicRecord::all();
        return response()->json(['success' => true, 'data' => $studentTopicRecords]);
    }

    //Hiển thị thông tin sinh viên đã hoàn thành chủ đề theo id
    public function show($id)
    {
        $studentTopicRecord = StudentTopicRecord::where('student_topic_record_id', $id)->first();
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
            'is_completed' => 'required|boolean'
        ]);
        //Sinh tự động student_topic_record_id
        $lastRecord = StudentTopicRecord::orderBy('student_topic_record_id')->first();
        if (!$lastRecord) {
            $studentTopicRecordId = 'student_topic_record_1';
        } else {
            $lastId = (int) str_replace('student_topic_record_', '', $lastRecord->student_topic_record_id);
            $studentTopicRecordId = 'student_topic_record_' . ($lastId + 1);
        }
        $validated['student_topic_record_id'] = $studentTopicRecordId;
        $studentTopicRecord = StudentTopicRecord::create($validated);
        return response()->json(['success' => true, 'data' => $studentTopicRecord]);
    }

    //Cập nhật bản ghi sinh viên cho chủ đề
    public function update(Request $request, $id)
    {
        $studentTopicRecord = StudentTopicRecord::where('student_topic_record_id', $id)->first();
        if (!$studentTopicRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi sinh viên cho chủ đề này!']);
        }
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'topic_id' => 'required|exists:topic,topic_id',
            'is_completed' => 'required|boolean'
        ]);
        $studentTopicRecord->update($validated);
        return response()->json(['success' => true, 'data' => $studentTopicRecord]);
    }

    //Xóa bản ghi sinh viên cho chủ đề
    public function destroy($id)
    {
        $studentTopicRecord = StudentTopicRecord::where('student_topic_record_id', $id)->first();
        if (!$studentTopicRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi sinh viên cho chủ đề này!']);
        }
        $studentTopicRecord->delete();
        return response()->json(['success' => true, 'message' => 'Bản ghi sinh viên cho chủ đề đã được xóa thành công!']);
    }
}
