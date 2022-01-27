<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MessageReadedBy;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'message',
        'created_by'
    ];

    public function readedMesssage()
    {
    	return $this->hasOne(MessageReadedBy::class,'message_id');
    }
}
