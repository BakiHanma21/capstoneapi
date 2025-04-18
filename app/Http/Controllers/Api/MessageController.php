<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    /**
     * @group Message API
     * 
     * Get All Message
     */
    public function index(Request $request)
    {
        $messages = Message::paginate();

        return MessageResource::collection($messages);
    }

    /**
     * @group Message API
     * 
     * Store Message
     */
    public function store(MessageRequest $request): Message
    {
        return Message::create($request->validated());
    }

    /**
     * @group Message API
     * 
     * Show Message
     */
    public function show(Message $message): Message
    {
        return $message;
    }

     /**
     * @group Message API
     * 
     * Update Message
     */
    public function update(MessageRequest $request, Message $message): Message
    {
        $message->update($request->validated());

        return $message;
    }

    /**
     * @group Message API
     * 
     * Delete Message
     */
    public function destroy(Message $message): Response
    {
        $message->delete();

        return response()->noContent();
    }
}
