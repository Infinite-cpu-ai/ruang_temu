<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Answer;

class QuestionAnswered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $answer;
    public $questionId;
    public $sessionId;

    /**
     * Create a new event instance.
     */
    public function __construct(Answer $answer)
    {
        $answer->load('architect', 'question');
        $this->answer = $answer;
        $this->questionId = $answer->question_id;
        $this->sessionId = $answer->question->session_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public.question.' . ($this->sessionId ?? $this->questionId)),
        ];
    }
}
