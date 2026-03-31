<?php

namespace App\Http\Controllers;

use App\Events\QuestionCreated;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuickAskController extends Controller
{
    public function index(Request $request)
    {
        // Generate or get session ID for guest tracking
        if (!$request->session()->has('guest_session_id')) {
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
            'channel' => 'public.question.' . $sessionId
        ]);
    }
}
