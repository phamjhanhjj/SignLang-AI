<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\StudentTopicRecord;
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
        $student = Student::create([
            'student_id' => $data['student_id'],
            'username' => $data['username'] ?? null, // Cho phép username null
            'age' => $data['age'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
        ]);

        // Tạo bản ghi StudentTopicRecord mặc định cho student
        StudentTopicRecord::create([
            'student_id' => $student->student_id,
            'topic_id' => 'topic_1',
            'is_completed' => false,
            'current_word' => 0, // current_word là 0 khi tạo mới
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $student;
    }

    public function update(Request $request, $studentId)
    {
        try {
            // Check if request is JSON
            if (!$request->isJson()) {
                return $this->errorResponse('Invalid request format, JSON expected', 400);
            }

            // Validate data (only student_id must match URL parameter)
            $validator = Validator::make(array_merge(['student_id' => $studentId], $request->json()->all()), [
                'student_id' => 'required|string|exists:student,student_id',
                'username' => 'nullable|string',
                'age' => 'nullable|integer',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', ['errors' => $validator->errors()]);
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            // Find student by student_id
            $student = Student::where('student_id', $studentId)->first();
            if (!$student) {
                Log::warning('Student not found', ['student_id' => $studentId]);
                return $this->errorResponse('Student not found', 404);
            }

            // Get JSON data
            $data = $request->json()->all();

            // Prepare update data, only include provided fields
            $updateData = [];
            if (array_key_exists('username', $data)) {
                $updateData['username'] = $data['username'] === '' ? null : $data['username'];
            }
            if (array_key_exists('age', $data)) {
                $updateData['age'] = $data['age'] === '' ? null : $data['age'];
            }
            if (array_key_exists('date_of_birth', $data)) {
                $updateData['date_of_birth'] = $data['date_of_birth'] === '' ? null : $data['date_of_birth'];
            }
            if (array_key_exists('gender', $data)) {
                $updateData['gender'] = $data['gender'] === '' ? null : $data['gender'];
            }

            // Update student with provided fields only
            $student->update($updateData);

            Log::info('Student updated successfully', ['student_id' => $studentId, 'updated_fields' => $updateData]);

            return $this->successResponse('Student updated successfully', 200, [
                'student_id' => $student->student_id,
                'username' => $student->username,
                'age' => $student->age,
                'date_of_birth' => $student->date_of_birth ? $student->date_of_birth->toDateString() : null,
                'gender' => $student->gender,
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating student', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->errorResponse('Server error', 500);
        }
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
