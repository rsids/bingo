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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/users', 'API\UserController@import');
Route::resource('rounds', 'App\Http\Controllers\API\RoundController');
Route::resource('tracks', 'App\Http\Controllers\API\TrackController');
Route::resource('users', 'App\Http\Controllers\API\UserController');
Route::resource('cards', 'App\Http\Controllers\API\CardController');
