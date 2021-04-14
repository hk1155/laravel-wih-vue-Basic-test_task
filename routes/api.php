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


Route::post('test','InviteController@invite');

Route::get('invitation','InviteController@check');

Route::post('storeuser','InviteController@store');
Route::get('verify/{id}','InviteController@verify');

Route::post('login','Api\UserController@checklogin');

Route::post('profile','Api\UserController@profile');
