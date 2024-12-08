<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function(){
  return redirect()->route('HOME');
});

Route::get('/task/{id?}', '\App\Http\Controllers\TaskController@_index')->name('HOME');
Route::post('/new/task', '\App\Http\Controllers\TaskController@_addNewTask')->name('N.T');
Route::post('/update/task', '\App\Http\Controllers\TaskController@_updateTask')->name('U.T');
Route::get('/delete/task/{id}', '\App\Http\Controllers\TaskController@_deleteTask')->name('D.T');
Route::get('/search', '\App\Http\Controllers\TaskController@_search')->name('SE.T');
Route::get('/filter', '\App\Http\Controllers\TaskController@_filter')->name('FI.T');

Route::get('/signin', '\App\Http\Controllers\AuthController@_signin')->name('LOG.F');
Route::post('/login', '\App\Http\Controllers\AuthController@_login')->name('LOG');
Route::get('/signup', '\App\Http\Controllers\AuthController@_signup')->name('REG.F');
Route::post('/register', '\App\Http\Controllers\AuthController@_register')->name('REG');
Route::get('/logout', '\App\Http\Controllers\AuthController@_logout')->name('LOGOUT');
