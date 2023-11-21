<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'body',
        'sender_id',
        'receiver_id',
        'conversation_id',
        'read',
        'type',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    use HasFactory;
}
