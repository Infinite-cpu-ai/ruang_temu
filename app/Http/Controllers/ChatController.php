<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($architect_id = null)
    {
        $user = Auth::user();

        // Find contacts (people who sent or received messages from auth user)
        $sentTo = Message::where('sender_id', $user->id)->pluck('receiver_id');
        $receivedFrom = Message::where('receiver_id', $user->id)->pluck('sender_id');

        $contactIds = $sentTo->merge($receivedFrom)->unique();

        // If clicking on an architect profile, force them into the contact list
        if ($architect_id && ! $contactIds->contains($architect_id)) {
            $contactIds->push($architect_id);
        }

        $contacts = User::whereIn('id', $contactIds)->with('architectProfile')->get();

        // Default target is the selected architect or the first contact
        $targetId = $architect_id ?? $contacts->first()?->id;
        $targetUser = $targetId ? User::with('architectProfile')->find($targetId) : null;

        // Fetch messages if a target is selected
        $messages = [];
        if ($targetUser) {
            $messages = Message::where(function ($query) use ($user, $targetUser) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $targetUser->id);
            })->orWhere(function ($query) use ($user, $targetUser) {
                $query->where('sender_id', $targetUser->id)
                    ->where('receiver_id', $user->id);
            })->orderBy('created_at', 'asc')->get();
        }

        return view('features.chat', compact('contacts', 'targetUser', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Broadcast the event
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function fetchMessages($receiverId)
    {
        // ... handled directly in index for simplicity right now
    }
}
