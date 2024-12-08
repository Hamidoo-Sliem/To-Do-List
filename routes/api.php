<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () { 
    Route::post('/login', '\App\Http\Controllers\Api\AuthController@_login');
    Route::post('/register', '\App\Http\Controllers\Api\AuthController@_register');
    Route::post('/logout', '\App\Http\Controllers\Api\AuthController@_logout');

    Route::post('/new/task', '\App\Http\Controllers\Api\TaskController@_addNewTask');
    Route::post('/update/task/{id}', '\App\Http\Controllers\Api\TaskController@_updateTask');
    Route::post('/delete/task/{id}', '\App\Http\Controllers\Api\TaskController@_deleteTask');
    Route::get('/list/tasks', '\App\Http\Controllers\Api\TaskController@_viewTasks');
    Route::get('/list/deleted/tasks', '\App\Http\Controllers\Api\TaskController@_viewDeletedTasks');
    Route::post('/restore/task/{id}', '\App\Http\Controllers\Api\TaskController@_restoreTask');
});	
