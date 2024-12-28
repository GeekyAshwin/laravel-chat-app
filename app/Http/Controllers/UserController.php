<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Message;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $code = $request->input('login_code');
        $user = User::whereChatCode($code)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Invalid Code'
            ], 422);
        } else {
            session(['user_id' => $user->id]);
            session(['username' => $user->name]);
            session(['email' => $user->email]);
            session(['user_loggedin' => true]);

            return response()->json([
                'message' => 'Login Successfuly'
            ], 200);
        }

    }

    public function showChatPage(Request $request , $chatCode)
    {
        if (!session('user_loggedin')) {
            $user = $this->generateUser();
            session(['user_id' => $user->id]);
            session(['username' => $user->name]);
            session(['email' => $user->email]);
            session(['user_loggedin' => true]);
        } else {
            $user = User::whereId(session('user_id'))->first();
        }

        $users = $this->getUserByChatCode($chatCode);
        $messages = Message::where([
            ['sent_by', '=', $user->id],
            ['sent_to', '=', $users->toArray()[0]['id']],
        ])->orWhere([
            ['sent_by', '=', $users->toArray()[0]['id']],
            ['sent_to', '=',  $user->id],
        ])->get();

        return view('chat', compact('user', 'users', 'messages'));
    }

    public function generateUser()
    {
        $user = User::factory()->create();
        return $user;
    }

    public function getUserByChatCode($chatCode)
    {
        return User::whereChatCode($chatCode)->get();
    }

    public function logout()
    {
        session()->flush();
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }

}
