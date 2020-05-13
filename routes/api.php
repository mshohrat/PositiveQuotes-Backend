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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::get('/test', function (Request $request) {
//    return "welcome";
//});

Route::group([
    'prefix' => 'v1/auth'
], function () {
    Route::post('signup', 'AuthController@signup');
    Route::middleware('token.need')->post('login', 'ApiTokenController@issueToken');

    Route::group([
        'middleware' => ['auth:api','identify']
    ], function() {
        Route::get('user', 'AuthController@user');
    });
});
