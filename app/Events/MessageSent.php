<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        return [
            new Channel('chat.' . $this->chat->receiver_id),
            new Channel('chat.' . $this->chat->sender_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'chat' => [
                'id' => $this->chat->id,
                'sender_id' => $this->chat->sender_id,
                'receiver_id' => $this->chat->receiver_id,
                'message' => $this->chat->message,
                'file_path' => $this->chat->file_path,
                'file_name' => $this->chat->file_name,
                'file_type' => $this->chat->file_type,
                'file_url' => $this->chat->file_url,
                'created_at' => $this->chat->created_at->toDateTimeString(),
                'read_at' => $this->chat->read_at ? $this->chat->read_at->toDateTimeString() : null,
            ]
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}