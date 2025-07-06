<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentPractiseVideoRecord;
class StudentPractiseVideoRecordController extends Controller
{
    //Hiener thị danh sách video thực hành của học sinh
    public function index()
    {
        $studentPractiseVideoRecords = StudentPractiseVideoRecord::all();
        return response()->json(['success' => true, 'data' => $studentPractiseVideoRecords]);
    }

    //Hiển thị thông tin video thực hành của học sinh theo id
    public function show($id)
    {
        $studentPractiseVideoRecord = StudentPractiseVideoRecord::where('student_practise_video_record_id', $id)->first();
        if (!$studentPractiseVideoRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi video thực hành của học sinh!']);
        }
        return response()->json(['success' => true, 'data' => $studentPractiseVideoRecord]);
    }

    //Thêm mới bản ghi video thực hành của học sinh
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'practise_video_id' => 'required|exists:practise_video,practise_video_id',
            'is_learned' => 'boolean',
            'replay_time' => 'integer|min:0',
            'is_mastered' => 'boolean'
        ]);
        //Sinh tự động student_practise_video_record_id theo dạng student_practise_video_record_1, student_practise_video_record_2, ...
        $lastRecord = StudentPractiseVideoRecord::latest('student_practise_video_record_id')->first();
        if (!$lastRecord) {
            $studentPractiseVideoRecordId = 'student_practise_video_record_1';
        } else {
            $lastId = (int) str_replace('student_practise_video_record_', '', $lastRecord->student_practise_video_record_id);
            $studentPractiseVideoRecordId = 'student_practise_video_record_' . ($lastId + 1);
        }
        $validated['student_practise_video_record_id'] = $studentPractiseVideoRecordId;
        $studentPractiseVideoRecord = StudentPractiseVideoRecord::create($validated);
        return response()->json(['success' => true, 'data' => $studentPractiseVideoRecord]);
    }

    //Cập nhật thông tin bản ghi video thực hành của học sinh
    public function update(Request $request, $id)
    {
        $studentPractiseVideoRecord = StudentPractiseVideoRecord::where('student_practise_video_record_id', $id)->first();
        if (!$studentPractiseVideoRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi video thực hành của học sinh!']);
        }
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'practise_video_id' => 'required|exists:practise_video,practise_video_id',
            'is_learned' => 'boolean',
            'replay_time' => 'integer|min:0',
            'is_mastered' => 'boolean'
        ]);
        $studentPractiseVideoRecord->update($validated);
        return response()->json(['success' => true, 'data' => $studentPractiseVideoRecord]);
    }

    //Xóa bản ghi video thực hành của học sinh
    public function destroy($id)
    {
        $studentPractiseVideoRecord = StudentPractiseVideoRecord::where('student_practise_video_record_id', $id)->first();
        if (!$studentPractiseVideoRecord) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bản ghi video thực hành của học sinh!']);
        }
        $studentPractiseVideoRecord->delete();
        return response()->json(['success' => true, 'message' => 'Bản ghi video thực hành của học sinh đã được xóa thành công!']);
    }
}
