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
    Route::post('signup', 'UserController@signup');
    Route::middleware('token.need')->post('login', 'ApiTokenController@issueToken');
    Route::middleware('is.guest')->post('login-as-guest', 'ApiTokenController@issueToken');

    Route::group([
        'middleware' => ['auth:api']
    ], function() {
        Route::group([
            'middleware' => ['identify']
        ], function() {
            Route::get('user', 'UserController@user');

            Route::get('profile', 'ProfileController@get');
            Route::put('profile', 'ProfileController@edit');
        });

        Route::middleware('check.user.role:'.\App\Role\UserRole::ROLE_ADMIN)->get('role', function(){
            return "success";
        });
    });
});
