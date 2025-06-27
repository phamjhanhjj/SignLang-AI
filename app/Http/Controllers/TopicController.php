<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
class TopicController extends Controller
{
    //Thêm mới topic
    public function store(Request $request){
        $validated = $request->validate([
            'course_id' => 'required|exists:course,course_id',
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1',
            'number_of_word' => 'required|integer|min:0'
        ]);

        //Sinh tự động topic_id theo dạng topic_1, topic_2, ...
        $lastTopic = Topic::orderBy('topic_id')->first();
        if (!$lastTopic) {
            $topicId = 'topic_1';
        } else {
            $lastId = (int) str_replace('topic_', '', $lastTopic->topic_id);
            $topicId = 'topic_' . ($lastId + 1);
        }
        $validated['topic_id'] = $topicId;

        $topic = Topic::create($validated);
        return response()->json(['success' => true, 'data' => $topic]);
    }

    //Hiển thị thông tin topic theo id
    public function show($id){
        $topic = Topic::where('topic_id', $id)->first();
        if (!$topic) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy chủ đề!']);
        }
        return response()->json(['success' => true, 'data' => $topic]);
    }

    //Cập nhật thông tin topic
    public function update(Request $request, $id){
        $topic = Topic::where('topic_id', $id)->first();
        if (!$topic) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy chủ đề!']);
        }
        $validated = $request->validate([
            'course_id' => 'required|exists:course,course_id',
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1',
            'number_of_word' => 'required|integer|min:0'
        ]);
        $topic->update($validated);
        return response()->json(['success' => true, 'data' => $topic]);
    }

    //Xoá topic theo id
    public function destroy($id){
        $topic = Topic::where('topic_id', $id)->first();
        if (!$topic) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy chủ đề!']);
        }
        $topic->delete();
        return response()->json(['success' => true, 'message' => 'Xoá chủ đề thành công!']);
    }
}
