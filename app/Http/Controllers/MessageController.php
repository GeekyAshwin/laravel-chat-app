<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Throwable;
use App\Events\MessageSent;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            dd(session()->all());
            $message = Message::create([
                'sent_to' => 2,
                'sent_by' => session('user_id'),   //login user  id
                'message' => $request->input('message'),
                'has_attachment' => false
            ]);
            event(new MessageSent($message));

            return response()->json([
                'message' => 'Message sent',
                'data' => $message
            ]);

        } catch (Throwable $exception) {
            dd($exception);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
