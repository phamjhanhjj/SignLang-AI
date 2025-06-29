<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrolment;
class EnrolmentController extends Controller
{
    //    // Hiển thị danh sách đăng ký khóa học
    public function index()
    {
        $enrolments = Enrolment::all();
        return response()->json(['success' => true, 'data' => $enrolments]);
    }

    // Hiển thị thông tin đăng ký khóa học theo ID
    public function show($id)
    {
        $enrolment = Enrolment::where('enrolment_id', $id)->first();
        if (!$enrolment) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy đăng ký khóa học!']);
        }
        return response()->json(['success' => true, 'data' => $enrolment]);
    }

    // Thêm mới đăng ký khóa học
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:course,course_id',
            'student_id' => 'required|exists:student,student_id',
            'enrolment_datetime' => 'required|date',
            'is_completed' => 'boolean'
        ]);
        // Sinh tự động enrolment_id
        $lastEnrolment = Enrolment::orderBy('enrolment_id')->first();
        if (!$lastEnrolment) {
            $enrolmentId = 'enrolment_1';
        } else {
            $lastId = (int) str_replace('enrolment_', '', $lastEnrolment->enrolment_id);
            $enrolmentId = 'enrolment_' . ($lastId + 1);
        }
        $validated['enrolment_id'] = $enrolmentId;
        $enrolment = Enrolment::create($validated);
        return response()->json(['success' => true, 'data' => $enrolment]);
    }

    // Cập nhật thông tin đăng ký khóa học
    public function update(Request $request, $id)
    {
        $enrolment = Enrolment::where('enrolment_id', $id)->first();
        if (!$enrolment) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy đăng ký khóa học!']);
        }
        $validated = $request->validate([
            'course_id' => 'required|exists:course,course_id',
            'student_id' => 'required|exists:student,student_id',
            'enrolment_datetime' => 'required|date',
            'is_completed' => 'boolean'
        ]);
        $enrolment->update($validated);
        return response()->json(['success' => true, 'data' => $enrolment]);
    }

    // Xóa đăng ký khóa học
    public function destroy($id)
    {
        $enrolment = Enrolment::where('enrolment_id', $id)->first();
        if (!$enrolment) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy đăng ký khóa học!']);
        }
        $enrolment->delete();
        return response()->json(['success' => true, 'message' => 'Đăng ký khóa học đã được xóa thành công!']);
    }
}
