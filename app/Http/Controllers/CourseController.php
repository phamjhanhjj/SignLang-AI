<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
class CourseController extends Controller
{
    //Hiển thị
    public function show($id){
        $course = Course::where('course_id', $id)->first();
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy khóa học!']);
        }
        return response()->json(['success' => true, 'data' => $course]);
    }

    //Thêm khóa học
    public function store(Request $request) {
        $validated = $request->validate([
            'course_id' => 'required|unique:course,course_id',
            'nation' => 'required|string|max:255',
            'total_topic' => 'required|integer|min:0'
        ]);

        $course = Course::create($validated);
        return response()->json(['success' => true, 'data' => $course]);
    }

    //Cập nhật khóa học
    public function update(Request $request, $id) {
        $course = Course::where('course_id', $id)->first();
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy khóa học!']);
        }

        $validated = $request->validate([
            'nation' => 'required|string|max:255',
            'total_topic' => 'required|integer|min:0'
        ]);

        $course->update($validated);
        return response()->json(['success' => true, 'data' => $course]);
    }

    //Xóa khóa học
    public function destroy($id) {
        $course = Course::where('course_id', $id)->first();
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy khóa học!']);
        }

        $course->delete();
        return response()->json(['success' => true, 'message' => 'Khóa học đã được xóa thành công!']);
    }
}
