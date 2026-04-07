<?php

namespace App\Http\Controllers;

use App\Events\QuestionCreated;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuickAskController extends Controller
{
    public function index(Request $request)
    {
        // Architects see the live board to answer questions
        if (auth()->check() && auth()->user()->role === 'architect') {
            return redirect()->route('architect.live-board.index');
        }

        // Generate or get session ID for guest tracking
        if (! $request->session()->has('guest_session_id')) {
            $request->session()->put('guest_session_id', Str::uuid()->toString());
        }

        $sessionId = $request->session()->get('guest_session_id');

        return view('features.quick-ask', compact('sessionId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $sessionId = $request->session()->get('guest_session_id', Str::uuid()->toString());

        $question = Question::create([
            'client_id' => auth()->check() ? auth()->id() : null,
            'session_id' => $sessionId,
            'content' => $request->content,
            'status' => 'open',
        ]);

        // Dispatch Event to Arsitek
        broadcast(new QuestionCreated($question));

        return response()->json([
            'status' => 'success',
            'question' => $question,
            'channel' => 'public.question.'.$sessionId,
        ]);
    }

    public function rateAnswer(Request $request, Answer $answer): JsonResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);

        $answer->update([
            'rating' => $request->rating,
            'rating_feedback' => $request->feedback,
        ]);

        return response()->json(['status' => 'success']);
    }
}
