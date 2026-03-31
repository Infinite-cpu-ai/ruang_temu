<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use App\Events\QuestionAnswered;
use App\Events\QuestionClaimed;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class LiveBoardController extends Controller
{
    public function index()
    {
        // Get currently open questions OR questions specifically claimed by this architect but not answered yet
        $questions = Question::with('client')
            ->where('status', 'open')
            ->orWhere(function ($query) {
                $query->where('status', 'claimed')
                      ->where('architect_id', auth()->id())
                      ->whereNull('answered_at');
            })
            ->latest()
            ->get();

        return view('features.architect.live-board', compact('questions'));
    }

    public function claim(Question $question)
    {
        if ($question->status !== 'open') {
            return response()->json(['status' => 'error', 'message' => 'Pertanyaan sudah diambil arsitek lain.'], 403);
        }

        $question->update([
            'status' => 'claimed',
            'architect_id' => auth()->id(),
            'claimed_at' => now(),
        ]);

        broadcast(new QuestionClaimed($question));

        return response()->json(['status' => 'success', 'question' => $question]);
    }

    public function answer(Request $request, Question $question)
    {
        if ($question->architect_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Anda tidak berhak menjawab pertanyaan ini.'], 403);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $answer = Answer::create([
            'question_id' => $question->id,
            'architect_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $question->update([
            'status' => 'answered',
            'answered_at' => now(),
        ]);

        broadcast(new QuestionAnswered($answer));

        return response()->json(['status' => 'success', 'answer' => $answer]);
    }
}
