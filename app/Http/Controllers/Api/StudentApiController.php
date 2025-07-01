<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentApiController extends Controller
{
    public function receiveUserId(Request $request)
    {
        try {
            // Kiểm tra request có phải JSON không
            if (!$request->isJson()) {
                return $this->errorResponse('Invalid request format, JSON expected', 400);
            }

            // Xác thực dữ liệu
            $validator = Validator::make($request->json()->all(), [
                'student_id' => 'required|string|unique:student,student_id',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', ['errors' => $validator->errors()]);
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $data = $request->json()->all();
            $studentId = $data['student_id'];

            // Kiểm tra student_id đã tồn tại
            if ($this->studentExists($studentId)) {
                return $this->successResponse('Student already exists', 200, [
                    'student_id' => $studentId,
                ]);
            }

            // Tạo student mới
            $student = $this->createStudent($data);

            return $this->successResponse('Student created successfully', 201, [
                'student_id' => $student->student_id,
                'username' => $student->username,
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing request', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->errorResponse('Server error', 500);
        }
    }

    private function studentExists(string $studentId): bool
    {
        return Student::where('student_id', $studentId)->exists();
    }

    private function createStudent(array $data): Student
    {
        return Student::create([
            'student_id' => $data['student_id'],
            'username' => $data['username'] ?? null, // Cho phép username null
            'age' => $data['age'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
        ]);
    }

    private function successResponse(string $message, int $status, array $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    private function errorResponse(string $message, int $status): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'error_code' => $status,
            'message' => $message,
        ], $status);
    }
}
