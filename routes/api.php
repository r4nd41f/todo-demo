<?php

use Illuminate\Http\Request;

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

Route::middleware('auth')->get('user', function (Request $request) {
    return $request->user();
});

// TODO: use resource
Route::get('task', 'API\TaskController@index')->middleware('auth');
Route::get('calendar/{year}/{month}', 'API\TaskController@calendar')->middleware('auth');
Route::get('taskToDo', 'API\TaskController@todo')->middleware('auth');
Route::get('task/{id}', 'API\TaskController@show')->middleware('auth');
Route::post('task', 'API\TaskController@store')->middleware('auth');
Route::put('task/{id}', 'API\TaskController@update')->middleware('auth');
Route::delete('task/{id}', 'API\TaskController@destroy')->middleware('auth');