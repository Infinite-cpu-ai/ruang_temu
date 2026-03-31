<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Question;

class QuestionClaimed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $questionId;
    public $architectId;
    public $sessionId;

    /**
     * Create a new event instance.
     */
    public function __construct(Question $question)
    {
        $this->questionId = $question->id;
        $this->architectId = $question->architect_id;
        $this->sessionId = $question->session_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public.questions.board'), // For other architects
            new Channel('public.question.' . ($this->sessionId ?? $this->questionId)), // For the specific user/guest
        ];
    }
}
