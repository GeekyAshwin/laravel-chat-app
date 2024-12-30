<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserProfile\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = User::with('userProfile')->whereId(session('user_id'))->first();
        return view('profile.index', compact('profile'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profile = User::with('userProfile')->whereId(session('user_id'))->first();
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserProfileRequest $request, string $id)
    {
        $user = User::whereId($id)->first();
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        $user->userProfile->update([
            'phone' => $request->input('phone'),
            'skills' => $request->input('skills'),
        ]);
        return response()->json([
            'message' => 'Profile updated',
            'data' => $user
        ]);
    }
}
