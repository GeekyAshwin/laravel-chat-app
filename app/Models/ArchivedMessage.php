<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedMessage extends Model
{
    use HasFactory;
    protected $table = 'archived_messages';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
