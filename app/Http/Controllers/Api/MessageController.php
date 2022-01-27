<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CreateMessageRequest;
use App\Models\Group;
use App\Models\Message;
use App\Models\MessageReadedBy;

class MessageController extends BaseController
{

    protected $message;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateGroupRequest  $request
     * @param  $groupId
     * @param  $userId (If we use seesion/token auth login then we didn't need to pass because we can capture from session of login user)
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMessageRequest $request, $groupId, $userId)
    {
        if(!isGroupUser($groupId, $userId)){
            return $this->sendError(['User not allowed to send message in the group.'], 'Unauthorized access.');
        }

        $group = Group::find($groupId);

        $message = new Message();
        $message->message = $request->get('message');
        $message->created_by = $userId;
        $group->groupMessages()->save($message);

        $messageReadedBy = new MessageReadedBy();
        $messageReadedBy->user_id = $userId;
        $message->readedMesssage()->save($messageReadedBy);

        return $this->sendResponse($message, 'Message created successfully.');
    }

    /**
     * List a resource and update message read by fetched user.
     *
     * @param  $groupId
     * @param  $userId (If we use seesion/token auth login then we didn't need to pass because we can capture from session of login user)
     * @return \Illuminate\Http\Response
     */
    public function list($groupId, $userId, $last_message_id = null)
    {
        if(!isGroupUser($groupId, $userId)){
            return $this->sendError(['User not allowed to get message in the group.'], 'Unauthorized access.');
        }

        if(!empty($last_message_id)){
            $messages = Message::select([
                                    'messages.*',
                                    \DB::raw('IF(message_readed_bies.id IS NULL,0,1) as is_readed')
                                ])
                                ->leftJoin('message_readed_bies',function($query) use($userId){
                                    $query->on('message_readed_bies.message_id','=','messages.id');
                                    $query->where('user_id',$userId);
                                })
                                ->where('group_id', $groupId)
                                ->where('id','>',$last_message_id)
                                ->latest()
                                ->get();
        } else {
            $messages = Message::select([
                                    'messages.*',
                                    \DB::raw('IF(message_readed_bies.id IS NULL,0,1) as is_readed')
                                ])
                                ->leftJoin('message_readed_bies',function($query) use($userId){
                                    $query->on('message_readed_bies.message_id','=','messages.id');
                                    $query->where('user_id',$userId);
                                })
                                ->where('group_id', $groupId)
                                ->latest()
                                ->get();
        }
        
        foreach($messages as $message){
            if(MessageReadedBy::where('message_id',$message->id)->where('user_id',$userId)->count() === 0){
                $messageReadedBy = new MessageReadedBy();
                $messageReadedBy->user_id = $userId;
                $message->readedMesssage()->save($messageReadedBy);
            }
        }

        return $this->sendResponse($messages, 'Message listed successfully.');
    }

}