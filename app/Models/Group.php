<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\GroupUser;
use App\Models\Message;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by'
    ];

    public function groupUsers()
    {
    	return $this->hasMany(GroupUser::class,'group_id');
    }

    public function groupMessages()
    {
    	return $this->hasMany(Message::class,'group_id');
    }
}
