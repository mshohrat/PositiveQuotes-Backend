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

Route::get('/', 'HomeController@index');

Auth::routes();

//Route::group([
//    'middleware' => ['auth','check.user.role:'.\App\Role\UserRole::ROLE_ADMIN]
//], function() {
//    Route::get('/home', 'HomeController@index')->name('home');
//    Route::get('/profile', 'ProfileController@get');
//    Route::get('/profile/{id}', 'ProfileController@getById');
//});

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('user/active-users', ['as' => 'user.active_users', 'uses' => 'UserController@active_users']);
	Route::get('user/inactive-users', ['as' => 'user.inactive_users', 'uses' => 'UserController@inactive_users']);
	Route::post('user/search', ['as' => 'user.search', 'uses' => 'UserController@search']);
    Route::get('user/last-registered-users', 'UserController@last_15_days_users');
	Route::get('quote/all-quotes', ['as' => 'quote.quotes', 'uses' => 'QuoteController@quotes']);
    Route::get('quote/verified-quotes', ['as' => 'quote.verified_quotes', 'uses' => 'QuoteController@verified_quotes']);
    Route::get('quote/pending-quotes', ['as' => 'quote.pending_quotes', 'uses' => 'QuoteController@pending_quotes']);
    Route::post('quote/store', ['as' => 'quote.store', 'uses' => 'QuoteController@store']);
    Route::put('quote/{quote}/update', ['as' => 'quote.update', 'uses' => 'QuoteController@update']);
    Route::get('quote/{quote}/edit', ['as' => 'quote.edit', 'uses' => 'QuoteController@edit']);
    Route::delete('quote/{quote}/destroy', ['as' => 'quote.destroy', 'uses' => 'QuoteController@destroy']);
    Route::post('quote/search', ['as' => 'quote.search', 'uses' => 'QuoteController@search']);
    Route::get('quote/last-all-quotes', 'QuoteController@last_all_quotes');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

