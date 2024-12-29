<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Cache;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserId = session('user_id');
        $usersCacheKey = "users_except_{$currentUserId}";

        // Retrieve users from cache or database
        $users = Cache::remember($usersCacheKey, now()->addMinutes(10), function () use ($currentUserId) {
            return User::whereNot('id', $currentUserId)->get();
        });

        // Check if there are users available
        if ($users->isEmpty()) {
            return view('chat', compact('users'))->with('messages', []);
        }

        // Cache key for messages with the first user in the list
        $firstUserId = $users[0]->id;
        $messagesCacheKey = "conversation_{$currentUserId}_{$firstUserId}";

        // Retrieve messages from cache or database
        $messages = Cache::remember($messagesCacheKey, now()->addMinutes(10), function () use ($currentUserId, $firstUserId) {
            return Message::where([
                ['sent_by', '=', $currentUserId],
                ['sent_to', '=', $firstUserId],
            ])->orWhere([
                ['sent_by', '=', $firstUserId],
                ['sent_to', '=', $currentUserId],
            ])->get();
        });

        return view('chat', compact('users', 'messages'));
    }
}
