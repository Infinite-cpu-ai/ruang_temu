<?php

namespace App\Http\Controllers;

use App\Events\MessageReceiptUpdated;
use App\Events\MessageSent;
use App\Http\Requests\MarkMessageDeliveredRequest;
use App\Http\Requests\SendChatMessageRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(?string $architect_id = null)
    {
        $user = Auth::user();
        $selectedId = $architect_id !== null && $architect_id !== '' ? (int) $architect_id : null;

        $sentTo = Message::query()->where('sender_id', $user->id)->pluck('receiver_id');
        $receivedFrom = Message::query()->where('receiver_id', $user->id)->pluck('sender_id');
        $messageContactIds = $sentTo->merge($receivedFrom)->unique()->values();

        if ($user->role === 'user') {
            $activeArchitectIds = User::query()
                ->where('role', 'architect')
                ->where('is_active', true)
                ->pluck('id');

            $architectPartnerIdsFromMessages = User::query()
                ->whereIn('id', $messageContactIds)
                ->where('role', 'architect')
                ->pluck('id');

            $contactIds = $activeArchitectIds->merge($architectPartnerIdsFromMessages)->unique()->values();

            if ($selectedId !== null) {
                $picked = User::query()->with('architectProfile')->find($selectedId);
                if (! $picked || $picked->role !== 'architect') {
                    $selectedId = null;
                } elseif (! $contactIds->contains($selectedId)) {
                    $contactIds->push($selectedId);
                }
            }
        } elseif ($user->role === 'architect') {
            $contactIds = $messageContactIds;
            $clientIdsFromProjects = Project::query()
                ->where('architect_id', $user->id)
                ->pluck('user_id');
            $contactIds = $contactIds->merge($clientIdsFromProjects)->unique()->values();

            if ($selectedId !== null && ! $contactIds->contains($selectedId)) {
                $contactIds->push($selectedId);
            }
        } else {
            $contactIds = $messageContactIds;

            if ($selectedId !== null && ! $contactIds->contains($selectedId)) {
                $contactIds->push($selectedId);
            }
        }

        $contactIds = $contactIds
            ->map(fn ($id) => (int) $id)
            ->filter(fn (int $id) => $id !== (int) $user->id)
            ->unique()
            ->values();

        $contacts = User::query()
            ->whereIn('id', $contactIds)
            ->with('architectProfile')
            ->orderBy('name')
            ->get();

        $targetId = $selectedId ?? $contacts->first()?->id;
        $targetUser = $targetId ? User::query()->with('architectProfile')->find($targetId) : null;

        $messages = collect();
        if ($targetUser) {
            $this->markIncomingMessagesProgress($user, $targetUser);

            $messages = Message::query()
                ->where(function ($query) use ($user, $targetUser) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $targetUser->id);
                })
                ->orWhere(function ($query) use ($user, $targetUser) {
                    $query->where('sender_id', $targetUser->id)
                        ->where('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('features.chat', compact('contacts', 'targetUser', 'messages'));
    }

    public function sendMessage(SendChatMessageRequest $request)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->validated('receiver_id'),
            'message' => $request->validated('message'),
            'is_read' => false,
            'delivered_at' => null,
            'read_at' => null,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function markDelivered(MarkMessageDeliveredRequest $request)
    {
        $message = Message::query()->findOrFail($request->validated('message_id'));

        if ((int) $message->receiver_id !== (int) Auth::id()) {
            abort(403);
        }

        if ($message->delivered_at === null) {
            $message->delivered_at = now();
            $message->save();
            broadcast(new MessageReceiptUpdated($message));
        }

        return response()->noContent();
    }

    public function fetchMessages(int $receiverId)
    {
        $user = Auth::user();

        $messages = Message::query()
            ->where(function ($query) use ($user, $receiverId) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($user, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    private function markIncomingMessagesProgress(User $user, User $targetUser): void
    {
        $messages = Message::query()
            ->where('sender_id', $targetUser->id)
            ->where('receiver_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('delivered_at')
                    ->orWhereNull('read_at');
            })
            ->get();

        foreach ($messages as $message) {
            $dirty = false;

            if ($message->delivered_at === null) {
                $message->delivered_at = now();
                $dirty = true;
            }

            if ($message->read_at === null) {
                $message->read_at = now();
                $message->is_read = true;
                $dirty = true;
            }

            if ($dirty) {
                $message->save();
                broadcast(new MessageReceiptUpdated($message));
            }
        }
    }
}
