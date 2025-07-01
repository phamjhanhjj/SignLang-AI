<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentApiController extends Controller
{
    public function receiveUserId(Request $request)
    {
        try {
            // Debug: Log toàn bộ request
            Log::info('Request received:', [
                'headers' => $request->headers->all(),
                'body' => $request->getContent(),
                'json' => $request->json()->all(),
                'all' => $request->all()
            ]);

            // Lấy dữ liệu JSON từ body
            $data = $request->json()->all();

            // Debug: Kiểm tra dữ liệu nhận được
            Log::info('Data received:', $data);

            // Kiểm tra xem userId có tồn tại không
            if (!isset($data['userId']) || empty($data['userId'])) {
                Log::error('userId not found in request data');
                return response()->json([
                    'success' => false,
                    'message' => 'userId not found in request',
                    'received_data' => $data
                ], 400);
            }

            $userId = $data['userId'];
            Log::info('Processing userId: ' . $userId);

            // Kiểm tra xem student_id đã tồn tại chưa
            $existingStudent = Student::where('student_id', $userId)->first();
            if ($existingStudent) {
                Log::info('Student already exists: ' . $userId);
                return response()->json([
                    'success' => true,
                    'message' => 'Student already exists',
                    'student_id' => $userId,
                    'data' => $existingStudent
                ], 200);
            }

            // Tạo student mới với student_id = userId
            Log::info('Creating new student with ID: ' . $userId);
            $student = Student::create([
                'student_id' => $userId,
                'username' => null,
                'age' => null,
                'date_of_birth' => null,
                'gender' => null
            ]);

            Log::info('Student created successfully: ' . $userId);
            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'student_id' => $userId,
                'data' => $student
            ], 201);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
