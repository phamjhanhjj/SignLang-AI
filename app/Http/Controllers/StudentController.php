<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentProgress;
class StudentController extends Controller
{
    //Hiển thị danh sách sinh viên
    public function index()
    {
        $students = Student::all();
        return response()->json(['success' => true, 'data' => $students]);
    }
    public function show($id)
    {
        $student = Student::where('student_id', $id)->first();
        return response()->json($student ?: ['success' => false, 'message' => 'Không tìm thấy sinh viên!']);
    }
     public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:student,student_id',
            'email_address' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'password' => 'required',
            'username' => 'required',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'gender' => 'required'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $student = Student::create($validated);

        // Tạo StudentProgress tự động khi tạo Student
        // StudentProgress::create([
        //     'student_id' => $student->student_id,

        // ]);
        return response()->json(['success' => true, 'data' => $student]);
    }

    // Cập nhật thông tin sinh viên
    public function update(Request $request, $id)
    {
        $student = Student::where('student_id', $id)->first();
        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sinh viên!']);
        }

        $validated = $request->validate([
            'email_address' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'username' => 'required',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'gender' => 'required'
        ]);

        // Nếu có nhập password mới thì cập nhật, không thì giữ nguyên
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $student->update($validated);

        return response()->json(['success' => true]);
    }

    // Xóa sinh viên
    public function destroy($id)
    {
        $student = Student::where('student_id', $id)->first();
        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sinh viên!']);
        }
        $student->delete();
        return response()->json(['success' => true]);
    }
}
