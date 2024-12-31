<?php

namespace App\Jobs;

use App\Models\ArchivedMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;
    /**
     * Create a new job instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            $this->message->update([
                'is_archived' => true
            ]);
            ArchivedMessage::create([
                'sent_by' => $this->message->sent_by,
                'sent_to' => $this->message->sent_to,
                'message' => $this->message->message,
                'has_attachment' => $this->message->has_attachment,
            ]);
            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Message Archived Error' .  $exception);
        }
    }
}
