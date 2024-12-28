<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

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
}
