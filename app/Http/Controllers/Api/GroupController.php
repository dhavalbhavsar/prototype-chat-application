<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\AddRemoveUserGroupRequest;
use App\Models\Group;
use App\Models\GroupUser;

class GroupController extends BaseController
{

    protected $group;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateGroupRequest  $request
     * @param  $userId (If we use seesion/token auth login then we didn't need to pass because we can capture from session of login user)
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request, $userId)
    {

        $group = $this->group->create([
            'name' => $request->get('name'),
            'created_by' => $userId
        ]);

        $groupUser = new GroupUser();
        $groupUser->user_id = $userId;
        $groupUser->is_admin = 1; // Default we made created user group admin.
        $groupUser->added_by = $userId;
        $group->groupUsers()->save($groupUser);

        return $this->sendResponse($group, 'Group created successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\AddRemoveUserGroupRequest  $request
     * @param  $groupId
     * @param  $userId (If we use seesion login then we didn't need to pass)
     * @return \Illuminate\Http\Response
     */
    public function addUser(AddRemoveUserGroupRequest $request, $groupId, $userId)
    {
        if(!isAdminAllowToAddUser($groupId, $userId)){
            return $this->sendError(['User not allowed to add user in the group.'], 'Unauthorized access.');
        }

        $group = Group::find($groupId);

        $groupUser = new GroupUser();
        $groupUser->user_id = $request->get('user_id');
        $groupUser->added_by = $userId;
        $group->groupUsers()->save($groupUser);

        return $this->sendResponse($group, 'Group user added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $groupId
     * @param  $userId (If we use seesion login then we didn't need to pass)
     * @return \Illuminate\Http\Response
     */
    public function removeUser(Request $request, $groupId, $userId)
    {
        if(!isAdminAllowToAddUser($groupId, $userId)){
            return $this->sendError(['User not allowed to remove user from the group.'], 'Unauthorized access.');
        }

        $group = Group::find($groupId);

        GroupUser::where([
            'group_id' => $groupId,
            'user_id' => $request->get('user_id')
        ])->delete();

        return $this->sendResponse($group, 'Group user removed successfully.');

    }

}