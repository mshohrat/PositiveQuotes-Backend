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
    'prefix' => 'v1'
], function () {
    Route::group([
        'prefix' => 'auth'
    ],function (){
        //Route::post('signup', 'ApiUserController@signup');
        Route::middleware('token.need')->post('login', 'ApiTokenController@issueToken');
        Route::middleware('is.guest')->post('login-as-guest', 'ApiTokenController@issueToken');
    });

    Route::group([
        'middleware' => ['auth:api']
    ], function() {
        Route::group([
            'middleware' => ['identify']
        ], function() {
            Route::get('user', 'ApiUserController@user');
            Route::get('config', 'ApiConfigController@config');
            Route::post('fb-token', 'ApiUserController@registerFbToken');
            Route::post('signup-from-guest', 'ApiUserController@signupFromGuest');
            Route::patch('edit-setting', 'ApiSettingController@edit');
            Route::get('quotes', 'ApiQuoteController@get10RandomQuotes');
            Route::get('profile', 'ApiProfileController@get');
            Route::put('profile', 'ApiProfileController@edit');
        });
    });

});


