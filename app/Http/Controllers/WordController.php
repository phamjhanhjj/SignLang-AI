<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Topic;
class WordController extends Controller
{
    //Hiển thị danh sách từ
    public function index()
    {
        $words = Word::all();
        return response()->json(['success' => true, 'data' => $words]);
    }

    //Hiển thị từ theo id
    public function show($id)
    {
        $word = Word::where('word_id', $id)->first();
        if (!$word) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy từ!']);
        }
        return response()->json(['success' => true, 'data' => $word]);
    }

    //Thêm từ
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id'=> 'required|exists:topic,topic_id',
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:255',
            'score' => 'required|integer|min:0'
        ]);
        //Sinh tự động id
        $lastWord = Word::latest('word_id')->first();
        if (!$lastWord) {
            $wordId = 'word_1';
        } else {
            $lastId = (int) str_replace('word_', '', $lastWord->word_id);
            $wordId = 'word_' . ($lastId + 1);
        }
        $validated['word_id'] = $wordId;
        $word = Word::create($validated);

        $topic = Topic::where('topic_id', $validated['topic_id'])->first();
        if ($topic){
            $topic->increment('number_of_word');
        }
        return response()->json(['success' => true, 'data' => $word]);
    }

    //Cập nhật từ
    public function update(Request $request, $id)
    {
        $word = Word::where('word_id', $id)->first();
        if (!$word) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy từ!']);
        }
        $validated = $request->validate([
            'topic_id' => 'required|exists:topic,topic_id',
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:255',
            'score' => 'required|integer|min:0'
        ]);
        $word->update($validated);
        return response()->json(['success' => true, 'data' => $word]);
    }

    //Xóa từ
    public function destroy($id)
    {
        $word = Word::where('word_id', $id)->first();
        if (!$word) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy từ!']);
        }
        $word->delete();
        $topic = Topic::where('topic_id', $word->topic_id)->first();
        if ($topic) {
            $topic->decrement('number_of_word');
        }
        return response()->json(['success' => true]);
    }
}
