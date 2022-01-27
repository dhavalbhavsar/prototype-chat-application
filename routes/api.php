<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('group/create/{user_id}', 'Api\GroupController@store');
Route::post('group/add-user/{group_id}/{user_id}', 'Api\GroupController@addUser');
Route::post('group/remove-user/{group_id}/{user_id}', 'Api\GroupController@removeUser');
Route::post('message/create/{group_id}/{user_id}', 'Api\MessageController@store');
Route::get('message/list/{group_id}/{user_id}/{last_message_id?}', 'Api\MessageController@list');