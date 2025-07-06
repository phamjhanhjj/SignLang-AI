<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentWordRecord;
class StudentWordRecordController extends Controller
{
    //Hiển thị danh sách Student Word Record
    public function index()
    {
        $studentWordRecords = StudentWordRecord::all();
        return response()->json(['success' => true, 'data' => $studentWordRecords]);
    }

    //Hiển thị thông tin Student Word Record theo id
    public function show($id)
    {
        $studentWordRecord = StudentWordRecord::where('student_word_record_id', $id)->first();
        if (!$studentWordRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi từ của học sinh!']);
        }
        return response()->json(['success' => true, 'data' => $studentWordRecord]);
    }

    //Thêm mới bản ghi từ của học sinh
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'word_id' => 'required|exists:word,word_id',
            'is_learned' => 'boolean',
            'replay_time' => 'integer|min:0',
            'is_mastered' => 'boolean'
        ]);
        //Sinh tự động student_word_record_id theo dạng student_word_record_1, student_word_record_2, ...
        $maxId = StudentWordRecord::all()->map(function($record) {
            return (int) str_replace('student_word_record_', '', $record->student_word_record_id);
        })->max() ?? 0;

        $studentWordRecordId = 'student_word_record_' . ($maxId + 1);
            $validated['student_word_record_id'] = $studentWordRecordId;
            $studentWordRecord = StudentWordRecord::create($validated);
            return response()->json(['success' => true, 'data' => $studentWordRecord]);
        }

    //Cập nhật thông tin bản ghi từ của học sinh
    public function update(Request $request, $id)
    {
        $studentWordRecord = StudentWordRecord::where('student_word_record_id', $id)->first();
        if (!$studentWordRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi từ của học sinh!']);
        }
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'word_id' => 'required|exists:word,word_id',
            'is_learned' => 'boolean',
            'replay_time' => 'integer|min:0',
            'is_mastered' => 'boolean'
        ]);
        $studentWordRecord->update($validated);
        return response()->json(['success' => true, 'data' => $studentWordRecord]);
    }

    //Xóa bản ghi từ của học sinh
    public function destroy($id)
    {
        $studentWordRecord = StudentWordRecord::where('student_word_record_id', $id)->first();
        if (!$studentWordRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi từ của học sinh!']);
        }
        $studentWordRecord->delete();
        return response()->json(['success' => true, 'message' => 'Xoá bản ghi từ của học sinh thành công!']);
    }
}
