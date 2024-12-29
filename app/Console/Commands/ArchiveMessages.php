<?php

namespace App\Console\Commands;

use App\Jobs\ProcessMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\Message;
use Carbon\Carbon;

class ArchiveMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive Messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $messages = Message::where('created_at', '<', now()->subDays(30))->get();
            if (!count($messages)) {
                $this->info('No messages are there to archive....');
                return;
            }
            foreach ($messages as $message) {
                ProcessMessage::dispatch($message);
            }
            $this->info('Message Archived....');
            return;

        } catch (Throwable $exception) {
            Log::error('Archive message job failed'. $exception);
        }
    }
}
