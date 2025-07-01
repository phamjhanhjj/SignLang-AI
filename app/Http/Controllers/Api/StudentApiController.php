<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function receiveUserId(Request $request)
    {
        try {
            // Lấy dữ liệu JSON từ body
            $data = $request->json()->all();

            // Kiểm tra xem userId có tồn tại không
            if (!isset($data['userId']) || empty($data['userId'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'userId not found in request'
                ], 400);
            }

            $userId = $data['userId'];

            // Kiểm tra xem student_id đã tồn tại chưa
            $existingStudent = Student::where('student_id', $userId)->first();
            if ($existingStudent) {
                return response()->json([
                    'success' => true,
                    'message' => 'Student already exists',
                    'student_id' => $userId,
                    'data' => $existingStudent
                ], 200);
            }

            // Tạo student mới với student_id = userId
            $student = Student::create([
                'student_id' => $userId,
                'username' => null,
                'age' => null,
                'date_of_birth' => null,
                'gender' => null
            ]);

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
