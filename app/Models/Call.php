<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function callReceiver()
    {
        return $this->belongsTo(User::class, 'receiver');
    }

    public function callSender()
    {
        return $this->belongsTo(User::class, 'sender');
    }
}
