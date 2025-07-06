<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PractiseVideo;
class PractiseVideoController extends Controller
{
    //hiển thị danh sách video thực hành
    public function index()
    {
        $practiseVideos = PractiseVideo::all();
        return response()->json(['success' => true, 'data' => $practiseVideos]);
    }

    //hiển thị video thực hành theo id
    public function show($id)
    {
        $practiseVideo = PractiseVideo::where('practise_video_id', $id)->first();
        if (!$practiseVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video thực hành!']);
        }
        return response()->json(['success' => true, 'data' => $practiseVideo]);
    }

    //thêm video thực hành
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:course,course_id',
            'video_link' => 'required|url',
            'subtitle' => 'required|json',
            'score' => 'required|integer|min:0'
        ]);
        //Sinh tự động id
        $lastVideo = PractiseVideo::latest('practise_video_id')->first();
        if (!$lastVideo) {
            $practiseVideoId = 'practise_video_1';
        } else {
            $lastId = (int) str_replace('practise_video_', '', $lastVideo->practise_video_id);
            $practiseVideoId = 'practise_video_' . ($lastId + 1);
        }
        $validated['practise_video_id'] = $practiseVideoId;
        $practiseVideo = PractiseVideo::create($validated);
        return response()->json(['success' => true, 'data' => $practiseVideo]);
    }

    //cập nhật video thực hành
    public function update(Request $request, $id)
    {
        $practiseVideo = PractiseVideo::where('practise_video_id', $id)->first();
        if (!$practiseVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video thực hành!']);
        }
        $validated = $request->validate([
            'course_id' => 'required|exists:course,course_id',
            'video_link' => 'required|url',
            'subtitle' => 'required|json',
            'score' => 'required|integer|min:0'
        ]);
        $practiseVideo->update($validated);
        return response()->json(['success' => true, 'data' => $practiseVideo]);
    }
}
