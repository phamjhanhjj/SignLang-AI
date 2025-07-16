<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateWordApiController extends Controller
{
    public function updayteWord(Request $request, $userID)
    {
        //Nhận file json từ client
        $data = $request->json()->all();
        // Hiển thị ra dữ liệu nhận được
        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $data
        ], 200);
    }
}
