<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearnVideos;
class LearnVideosController extends Controller
{
    //hiển thị danh sách video học tập
    public function index()
    {
        $learnVideos = LearnVideos::all();
        return response()->json(['success' => true, 'data' => $learnVideos]);
    }

    //hiển thị video học tập theo id
    public function show($id)
    {
        $learnVideo = LearnVideos::where('learn_video_id', $id)->first();
        if (!$learnVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video học tập!']);
        }
        return response()->json(['success' => true, 'data' => $learnVideo]);
    }

    //thêm video học tập
    public function store(Request $request)
    {
        $validated = $request->validate([
            'word_id' => 'required|exists:word,word_id',
            'video_url' => 'required|url'
        ]);
        //Sinh tự động id
        $lastVideo = LearnVideos::latest('learn_video_id')->first();
        if (!$lastVideo) {
            $learnVideoId = 'learn_video_1';
        } else {
            $lastId = (int) str_replace('learn_video_', '', $lastVideo->learn_video_id);
            $learnVideoId = 'learn_video_' . ($lastId + 1);
        }
        $validated['learn_video_id'] = $learnVideoId;
        $learnVideo = LearnVideos::create($validated);
        return response()->json(['success' => true, 'data' => $learnVideo]);
    }

    //cập nhật video học tập
    public function update(Request $request, $id)
    {
        $learnVideo = LearnVideos::where('learn_video_id', $id)->first();
        if (!$learnVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video học tập!']);
        }
        $validated = $request->validate([
            'word_id' => 'required|exists:word,word_id',
            'video_url' => 'required|url'
        ]);
        $learnVideo->update($validated);
        return response()->json(['success' => true, 'data' => $learnVideo]);
    }

    //xóa video học tập
    public function destroy($id)
    {
        $learnVideo = LearnVideos::where('learn_video_id', $id)->first();
        if (!$learnVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video học tập!']);
        }
        $learnVideo->delete();
        return response()->json(['success' => true, 'message' => 'Xóa video học tập thành công!']);
    }
}
