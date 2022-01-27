<?php

use App\Models\Group;
use App\Models\GroupUser;

function isAdminAllowToAddUser($groupId, $userId){

	$countUser = Group::whereHas('groupUsers', function($query) use($groupId, $userId){
				   $query->where('group_id', $groupId);
				   $query->where('user_id', $userId);
				   $query->where('is_admin',1);
				})->where('id',$groupId)->count();

	return ($countUser > 0);
}

function isGroupUser($groupId, $userId){

	$countUser = GroupUser::where([
								'group_id' => $groupId,
								'user_id' => $userId
							])->count();

	return ($countUser > 0);
}