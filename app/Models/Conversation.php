<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $table = 'conversations';
    protected $fillable = [
        'receiver_id',
        'sender_id',
        'last_time_message'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function message()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }
}
