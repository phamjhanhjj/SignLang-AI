<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordPractiseVideo;
class WordPractiseVideoController extends Controller
{
    //Hiển thị danh sách video thực hành từ bảng word_practise_video
    public function index()
    {
        $wordPractiseVideos = WordPractiseVideo::all();
        return response()->json(['success' => true, 'data' => $wordPractiseVideos]);
    }

    //hiển thị thông tin video thực hành theo id
    public function show($id)
    {
        $wordPractiseVideo = WordPractiseVideo::where('word_practise_video_id', $id)->first();
        if (!$wordPractiseVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video thực hành!']);
        }
        return response()->json(['success' => true, 'data' => $wordPractiseVideo]);
    }

    //Thêm mới video thực hành
    public function store(Request $request)
    {
        $validated = $request->validate([
            'word_id' => 'required|exists:word,word_id',
            'practise_video_id' => 'required|exists:practise_video,practise_video_id',
        ]);
        //Sinh tự động word_practise_video_id theo dạng word_practise_video_1, word_practise_video_2, ...
        $lastWordPractiseVideo = WordPractiseVideo::latest('word_practise_video_id')->first();
        if (!$lastWordPractiseVideo) {
            $wordPractiseVideoId = 'word_practise_video_1';
        } else {
            $lastId = (int) str_replace('word_practise_video_', '', $lastWordPractiseVideo->word_practise_video_id);
            $wordPractiseVideoId = 'word_practise_video_' . ($lastId + 1);
        }
        $validated['word_practise_video_id'] = $wordPractiseVideoId;
        $wordPractiseVideo = WordPractiseVideo::create($validated);
        return response()->json(['success' => true, 'data' => $wordPractiseVideo]);
    }

    //Cập nhật thông tin video thực hành
    public function update(Request $request, $id)
    {
        $wordPractiseVideo = WordPractiseVideo::where('word_practise_video_id', $id)->first();
        if (!$wordPractiseVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video thực hành!']);
        }
        $validated = $request->validate([
            'word_id' => 'required|exists:word,word_id',
            'practise_video_id' => 'required|exists:practise_video,practise_video_id',
        ]);
        $wordPractiseVideo->update($validated);
        return response()->json(['success' => true, 'data' => $wordPractiseVideo]);
    }

    //Xóa video thực hành
    public function destroy($id)
    {
        $wordPractiseVideo = WordPractiseVideo::where('word_practise_video_id', $id)->first();
        if (!$wordPractiseVideo) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy video thực hành!']);
        }
        $wordPractiseVideo->delete();
        return response()->json(['success' => true, 'message' => 'Xóa video thực hành thành công!']);
    }
}
