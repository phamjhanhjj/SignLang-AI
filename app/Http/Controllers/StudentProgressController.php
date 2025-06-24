<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProgress;

class StudentProgressController extends Controller
{
    ///Lấy thông tin student progress
    public function show($student_id){
        $progress = StudentProgress::where('student_id', $student_id)->first();
        if (!$progress) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy tiến trình của sinh viên!']);
        }
        return response()->json(['success' => true, 'data' => $progress]);
    }
    ///Cập nhật thông tin student progress
    public function update(Request $request, $student_id){
        $validated = $request->validate([
            'total_score' => 'required|integer',
            'word_score' => 'required|integer',
            'video_score' => 'required|integer',
            'level' => 'required|integer|min:1'
        ]);

        $progress = StudentProgress::where('student_id', $student_id)->first();
        if (!$progress) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy tiến trình của sinh viên!']);
        }
        $progress->update($validated);
        return response()->json(['success' => true, 'data' => $progress]);
    }
}
