<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
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
        $imageUrl = '';
        if ($request->hasFile('profile_image')) {
            $imageUrl = $request->file('profile_image')->store('profiles', 'public');
        }
        $user->userProfile->update([
            'phone' => $request->input('phone'),
            'skills' => $request->input('skills'),
            'profile_image' => $imageUrl
        ]);
        return response()->json([
            'message' => 'Profile updated',
            'data' => $user
        ]);
    }
}
