<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Throwable;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loadMessages(Request $request)
    {
        $receiver = $request->input('receiver');
        $userId = session('user_id');
        $sentMessageKey = "conversation_{$userId}_{$receiver}";
        $sentMessages = Cache::get($sentMessageKey);

        $receivedMessageKey = "conversation_{$receiver}_{$userId}";
        $receivedMessages = Cache::get($receivedMessageKey);
        $messages = [];
        if ($sentMessages) {
            $sentMessages = is_array($sentMessages) ?  $sentMessages : $sentMessages->toArray();
            $messages = array_merge($sentMessages, $messages ) ;
        }
        if ($receivedMessages) {
            $receivedMessages = is_array($receivedMessages) ?  $receivedMessages : $receivedMessages->toArray();
            $messages = array_merge($receivedMessages, $messages ) ;
        }
        if (!$messages) {
            $messages = Message::where([
                ['sent_by', '=', $userId],
                ['sent_to', '=', $receiver],
            ])->orWhere([
                ['sent_by', '=', $receiver],
                ['sent_to', '=', $userId],
            ])->get();
            Cache::put($sentMessageKey, $messages, now()->addMinutes(10));
        }

        $messages =collect($messages)->sortBy('created_at')->values()->toArray();
        return response()->json([
            'data' => $messages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $message = Message::create([
                'sent_to' => $request->input('receiver'),
                'sent_by' => session('user_id'),   //login user  id
                'message' => $request->input('message'),
                'has_attachment' => false
            ]);
            $this->storeDataInRedis($request, $message);
            event(new MessageSent($message));

            return response()->json([
                'message' => 'Message sent',
                'data' => $message
            ]);
        } catch (Throwable $exception) {
            dd($exception);
        }
    }

    public function storeDataInRedis(Request $request, $message)
    {
        $cacheKey = 'conversation_' . session('user_id') . '_' . $request->input('receiver');
        $cachedMessages = Cache::get($cacheKey, []);
        $cachedMessages[] = $message;
        Cache::put($cacheKey, $cachedMessages, now()->addMinutes(10));
    }
}
