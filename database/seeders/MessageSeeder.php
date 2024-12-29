<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i =1; $i <=1000; $i++) {
            Message::create([
                'sent_by' => 1,
                'sent_to' => 2,
                'message' => 'Hello, This is a testing message',
                'has_attachment' => false,
            ]);
            Message::create([
                'sent_by' => 2,
                'sent_to' => 1,
                'message' => 'Hello, This is a testing message',
                'has_attachment' => false,
            ]);
        }
        return ;
    }
}
