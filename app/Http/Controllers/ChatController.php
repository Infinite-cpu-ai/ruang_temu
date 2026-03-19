<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Get unique users the current user has chatted with
        return view('features.chat');
    }

    public function sendMessage(Request $request) { /* Logic in Phase 6/Frontend */ }
    public function fetchMessages($receiverId) { /* Logic in Phase 6/Frontend */ }
}
