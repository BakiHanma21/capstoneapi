<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\ChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required_without:file|string|nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10000',
        ]);

        $sender = Auth::user();
        $receiverId = $request->receiver_id;
        $receiver = User::find($receiverId);

        // Check permissions based on roles
        if ($sender->role === 'USER' && $receiver->role === 'WORKER') {
            // Users can only message workers they have confirmed bookings with
            $hasBooking = Booking::where('customer_id', $sender->id)
                ->where('worker_id', $receiverId)
                ->where('status', 'CONFIRMED')
                ->exists();
        
            if (!$hasBooking) {
                return response()->json([
                    'error' => 'You can only message this worker after a confirmed booking.'
                ], 403);
            }
        } elseif ($sender->role === 'WORKER' && $receiver->role === 'USER') {
            // Workers can only message users who have confirmed bookings with them
            $hasBooking = Booking::where('worker_id', $sender->id)
                ->where('customer_id', $receiverId)
                ->where('status', 'CONFIRMED')
                ->exists();
        
            if (!$hasBooking) {
                return response()->json([
                    'error' => 'You can only message users who have confirmed bookings with you.'
                ], 403);
            }
        }
        // Admin can message anyone, so no additional check needed for admin

        $chat = new Chat();
        $chat->sender_id = $sender->id;
        $chat->receiver_id = $receiverId;
        $chat->message = $request->message;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            
            // Create upload directory if it doesn't exist
            $uploadPath = public_path('uploads/chat');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move the uploaded file
            $file->move($uploadPath, $fileName);
            
            // Store just the relative path
            $chat->file_path = 'uploads/chat/' . $fileName;
            $chat->file_name = $originalName;
            $chat->file_type = $extension;
        }

        $chat->save();

        // Add file URL to the response
        $chatResponse = $chat->toArray();
        if ($chat->file_path) {
            // Don't use url() helper, just append the path to the domain
            $chatResponse['file_url'] = $chat->file_path;
            $chatResponse['file_name'] = $chat->file_name;
            $chatResponse['file_type'] = $chat->file_type;
        }

        // Send notification to the receiver
        $receiver->notify(new ChatMessageNotification($chat, $sender));

        // Broadcast the message
        broadcast(new MessageSent($chat))->toOthers();

        return response()->json([
            'message' => 'Message sent successfully',
            'chat' => $chatResponse
        ], 201);
    }

    public function getMessages($receiverId)
    {
        $user = Auth::user();
        $receiver = User::find($receiverId);

        // Check permissions based on roles
        if ($user->role === 'USER' && $receiver->role === 'WORKER') {
            // Users can only view messages with workers they have confirmed bookings with
            $hasBooking = Booking::where('customer_id', $user->id)
                ->where('worker_id', $receiverId)
                ->where('status', 'CONFIRMED')
                ->exists();
        
            if (!$hasBooking) {
                return response()->json([
                    'error' => 'You can only message this worker after a confirmed booking.'
                ], 403);
            }
        } elseif ($user->role === 'WORKER' && $receiver->role === 'USER') {
            // Workers can only view messages with users who have confirmed bookings with them
            $hasBooking = Booking::where('worker_id', $user->id)
                ->where('customer_id', $receiverId)
                ->where('status', 'CONFIRMED')
                ->exists();
        
            if (!$hasBooking) {
                return response()->json([
                    'error' => 'You can only message users who have confirmed bookings with you.'
                ], 403);
            }
        }
        // Admin can view messages with anyone, so no additional check needed for admin

        $messages = Chat::where(function ($query) use ($user, $receiverId) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($user, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $user->id);
        })->get();

        // Add file URLs to the response
        $messagesResponse = $messages->map(function ($message) {
            $messageArray = $message->toArray();
            if ($message->file_path) {
                // Just use the relative path
                $messageArray['file_url'] = $message->file_path;
                $messageArray['file_name'] = $message->file_name;
                $messageArray['file_type'] = $message->file_type;
            }
            return $messageArray;
        });

        // Mark messages as read
        Chat::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messagesResponse);
    }

    public function conversations()
    {
        $user = Auth::user();
        $conversations = [];

        if ($user->role === 'USER') {
            // Users can only see workers they have confirmed bookings with
            $workers = User::where('role', 'WORKER')
                ->whereExists(function ($query) use ($user) {
                    $query->select(DB::raw(1))
                          ->from('bookings')
                          ->whereRaw('bookings.worker_id = users.id')
                          ->where('bookings.customer_id', $user->id)
                          ->where('bookings.status', 'CONFIRMED');
                })->get();

            foreach ($workers as $worker) {
                $latestMessage = Chat::where(function ($query) use ($user, $worker) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $worker->id);
                })->orWhere(function ($query) use ($user, $worker) {
                    $query->where('sender_id', $worker->id)
                          ->where('receiver_id', $user->id);
                })->latest()->first();

                $conversations[] = [
                    'id' => $worker->id,
                    'name' => $worker->name,
                    'role' => $worker->role,
                    'latest_message' => $latestMessage ? $latestMessage->message : null,
                    'latest_timestamp' => $latestMessage ? $latestMessage->created_at : null,
                    'unread_count' => Chat::where('sender_id', $worker->id)
                        ->where('receiver_id', $user->id)
                        ->whereNull('read_at')
                        ->count(),
                ];
            }

            // Add admin to conversations if there are messages
            $admin = User::where('role', 'ADMINISTRATOR')->first();
            if ($admin) {
                $hasMessages = Chat::where(function ($query) use ($user, $admin) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $admin->id);
                })->orWhere(function ($query) use ($user, $admin) {
                    $query->where('sender_id', $admin->id)
                        ->where('receiver_id', $user->id);
                })->exists();

                if ($hasMessages) {
                    $latestMessage = Chat::where(function ($query) use ($user, $admin) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $admin->id);
                    })->orWhere(function ($query) use ($user, $admin) {
                        $query->where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id);
                    })->latest()->first();

                    $conversations[] = [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'role' => $admin->role,
                        'latest_message' => $latestMessage ? $latestMessage->message : null,
                        'latest_timestamp' => $latestMessage ? $latestMessage->created_at : null,
                        'unread_count' => Chat::where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id)
                            ->whereNull('read_at')
                            ->count(),
                    ];
                }
            }

        } elseif ($user->role === 'WORKER') {
            // Workers can only see users who have confirmed bookings with them
            $users = User::where('role', 'USER')
                ->whereExists(function ($query) use ($user) {
                    $query->select(DB::raw(1))
                        ->from('bookings')
                        ->whereRaw('bookings.customer_id = users.id')
                        ->where('bookings.worker_id', $user->id)
                        ->where('bookings.status', 'CONFIRMED');
                })->get();

            foreach ($users as $u) {
                $latestMessage = Chat::where(function ($query) use ($user, $u) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $u->id);
                })->orWhere(function ($query) use ($user, $u) {
                    $query->where('sender_id', $u->id)
                          ->where('receiver_id', $user->id);
                })->latest()->first();

                $conversations[] = [
                    'id' => $u->id,
                    'name' => $u->name,
                    'role' => $u->role,
                    'latest_message' => $latestMessage ? $latestMessage->message : null,
                    'latest_timestamp' => $latestMessage ? $latestMessage->created_at : null,
                    'unread_count' => Chat::where('sender_id', $u->id)
                        ->where('receiver_id', $user->id)
                        ->whereNull('read_at')
                        ->count(),
                ];
            }

            // Add admin to conversations if there are messages
            $admin = User::where('role', 'ADMINISTRATOR')->first();
            if ($admin) {
                $hasMessages = Chat::where(function ($query) use ($user, $admin) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $admin->id);
                })->orWhere(function ($query) use ($user, $admin) {
                    $query->where('sender_id', $admin->id)
                        ->where('receiver_id', $user->id);
                })->exists();

                if ($hasMessages) {
                    $latestMessage = Chat::where(function ($query) use ($user, $admin) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $admin->id);
                    })->orWhere(function ($query) use ($user, $admin) {
                        $query->where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id);
                    })->latest()->first();

                    $conversations[] = [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'role' => $admin->role,
                        'latest_message' => $latestMessage ? $latestMessage->message : null,
                        'latest_timestamp' => $latestMessage ? $latestMessage->created_at : null,
                        'unread_count' => Chat::where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id)
                            ->whereNull('read_at')
                            ->count(),
                    ];
                }
            }
            
        } elseif ($user->role === 'ADMINISTRATOR') {
            // Admin can see all users and workers
            $allUsers = User::whereIn('role', ['USER', 'WORKER'])->get();
            foreach ($allUsers as $u) {
                $latestMessage = Chat::where(function ($query) use ($user, $u) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $u->id);
                })->orWhere(function ($query) use ($user, $u) {
                    $query->where('sender_id', $u->id)
                          ->where('receiver_id', $user->id);
                })->latest()->first();

                // Include all users and workers for admin, not just those with messages
                $conversations[] = [
                    'id' => $u->id,
                    'name' => $u->name,
                    'role' => $u->role,
                    'latest_message' => $latestMessage ? $latestMessage->message : null,
                    'latest_timestamp' => $latestMessage ? $latestMessage->created_at : null,
                    'unread_count' => Chat::where('sender_id', $u->id)
                        ->where('receiver_id', $user->id)
                        ->whereNull('read_at')
                        ->count(),
                ];
            }
        }

        return response()->json($conversations);
    }

    public function potentialChatUsers()
    {
        $user = Auth::user();
        $potentialUsers = [];

        if ($user->role === 'USER') {
            // Users can only start chats with workers they have confirmed bookings with
            $potentialUsers = User::where('role', 'WORKER')
                ->whereExists(function ($query) use ($user) {
                    $query->select(DB::raw(1))
                          ->from('bookings')
                          ->whereRaw('bookings.worker_id = users.id')
                          ->where('bookings.customer_id', $user->id)
                          ->where('bookings.status', 'CONFIRMED');
                })->get()->map(function ($worker) {
                    return [
                        'id' => $worker->id,
                        'name' => $worker->name,
                        'role' => $worker->role,
                    ];
                });
                
            // Add admin as a potential chat user
            $admin = User::where('role', 'ADMINISTRATOR')->first();
            if ($admin) {
                $potentialUsers->push([
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'role' => $admin->role,
                ]);
            }
            
        } elseif ($user->role === 'WORKER') {
            // Workers can only start chats with users who have confirmed bookings with them
            $potentialUsers = User::where('role', 'USER')
                ->whereExists(function ($query) use ($user) {
                    $query->select(DB::raw(1))
                          ->from('bookings')
                          ->whereRaw('bookings.customer_id = users.id')
                          ->where('bookings.worker_id', $user->id)
                          ->where('bookings.status', 'CONFIRMED');
                })->get()->map(function ($u) {
                    return [
                        'id' => $u->id,
                        'name' => $u->name,
                        'role' => $u->role,
                    ];
                });
                
            // Add admin as a potential chat user
            $admin = User::where('role', 'ADMINISTRATOR')->first();
            if ($admin) {
                $potentialUsers->push([
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'role' => $admin->role,
                ]);
            }
            
        } elseif ($user->role === 'ADMINISTRATOR') {
            // Admin can start chats with all users and workers
            $potentialUsers = User::whereIn('role', ['USER', 'WORKER'])->get()->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'role' => $u->role,
                ];
            });
        }

        return response()->json($potentialUsers);
    }

    public function markAsRead($receiverId)
    {
        $user = Auth::user();
        Chat::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        return response()->json(['message' => 'Messages marked as read']);
    }

    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();
        return response()->json($notifications);
    }

    public function markNotificationAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read']);
    }
}