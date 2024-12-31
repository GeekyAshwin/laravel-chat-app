<?php

namespace App\Http\Controllers;

use App\Events\Calls\CallAccepted;
use App\Events\Calls\CallEnded;
use App\Events\Calls\CallInitiated;
use App\Events\Calls\CallRejected;
use Illuminate\Http\Request;
use App\Models\Call;
use Illuminate\Support\Facades\Log;

class CallController extends Controller
{
    public function makeCall(Request $request)
    {
        try {
            $call = Call::create([
                'sender' => $request->input('sender'),
                'receiver' => $request->input('receiver'),
                'status' => 'Initiated',
            ]);
            $call->loadMissing('callReceiver', 'callSender');
            event(new CallInitiated($call));

            return response()->json([
                'data' => $call,
                'message' => 'Making a call ....'
            ]);

        } catch (\Throwable $exception) {
           Log::error('Something went wrong' . $exception);
        }
    }

    public function acceptCall(Request $request)
    {
        try {
            $call = $this->getCallById($request->input('call'));
            $this->updateCallStatus($call, 'Accepted');
            event(new CallAccepted($call));

            return response()->json([
                'data' => $call,
                'message' => 'Call Accepted'
            ]);

        } catch (\Throwable $exception) {
           Log::error('Something went wrong' . $exception);
        }
    }

    public function rejectCall(Request $request)
    {
        try {
            $call = $this->getCallById($request->input('call'));
            $this->updateCallStatus($call, 'Rejected');
            event(new CallRejected($call));

            return response()->json([
                'data' => $call,
                'message' => 'Rejected ....'
            ]);

        } catch (\Throwable $exception) {
           Log::error('Something went wrong' . $exception);
        }
    }

    public function endCall(Request $request)
    {
        try {
            $call = $this->getCallById($request->input('call'));
            $this->updateCallStatus($call, 'Ended');
            event(new CallEnded($call));

            return response()->json([
                'data' => $call,
                'message' => 'Call ended ....'
            ]);

        } catch (\Throwable $exception) {
           Log::error('Something went wrong' . $exception);
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
           Log::error('Something went wrong' . $exception);
        }
    }

    public function getCallById($callId)
    {
        return Call::whereId($callId)->first();
    }
}
