<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group([
    'middleware' => ['auth','check.user.role:'.\App\Role\UserRole::ROLE_ADMIN]
], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@get');
    Route::get('/profile/{id}', 'ProfileController@getById');
});
