<?php

namespace App\Http\Controllers;

use App\Events\Calls\CallAccepted;
use App\Events\Calls\CallEnded;
use App\Events\Calls\CallInitiated;
use App\Events\Calls\CallRejected;
use Illuminate\Http\Request;
use App\Models\Call;

class CallController extends Controller
{
    public function makeCall(Request $request)
    {
        try {
            $call = Call::create([
                'sender' => $request->input('sender'),
                'receiver' => $request->input('sender'),
                'sender' => $request->input('sender'),
            ]);
            event(new CallInitiated($call));

            return response()->json([
                'data' => $call,
                'message' => 'Making a call ....'
            ]);

        } catch (\Throwable $exception) {
            dd($exception);
        }
    }

    public function acceptCall(Call $call)
    {
        try {
            $call->updateCallStatus($call, 'Accepted');
            event(new CallAccepted($call));

            return response()->json([
                'data' => $call,
                'message' => 'Call Accepted'
            ]);

        } catch (\Throwable $exception) {
            dd($exception);
        }
    }

    public function rejectCall(Call $call)
    {
        try {
            $call->updateCallStatus($call, 'Rejected');
            event(new CallRejected($call));

            return response()->json([
                'data' => $call,
                'message' => 'Rejected ....'
            ]);

        } catch (\Throwable $exception) {
            dd($exception);
        }
    }

    public function endCall(Call $call)
    {
        try {
            $call->updateCallStatus($call, 'Ended');
            event(new CallEnded($call));

            return response()->json([
                'data' => $call,
                'message' => 'Call ended ....'
            ]);

        } catch (\Throwable $exception) {
            dd($exception);
        }
    }

    public function updateCallStatus(Call $call , $status)
    {
        try {
            $call->update([
                'status' => $status
            ]);
            $message = 'Dynamic message';
            return response()->json([
                'data' => $call,
                'message' => $message
            ]);

        } catch (\Throwable $exception) {
            dd($exception);
        }
    }
}
