<?php

namespace App\Notifications;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ChatMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $chat;
    protected $sender;

    public function __construct(Chat $chat, User $sender)
    {
        $this->chat = $chat;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'chat_id' => $this->chat->id,
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => $this->chat->message,
            'file_path' => $this->chat->file_path,
            'created_at' => $this->chat->created_at,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'chat_id' => $this->chat->id,
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => $this->chat->message,
            'file_path' => $this->chat->file_path,
            'created_at' => $this->chat->created_at,
        ]);
    }
} 