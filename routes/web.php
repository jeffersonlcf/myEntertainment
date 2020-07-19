<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('me', 'MeController')->only(['show']);

Route::get('/me/search/store', 'MeController@store_from_search')->name('me.search.store');
Route::get('/me/{me}/refresh', 'MeController@refresh')->name('me.refresh');
Route::get('/test', 'MeController@get_information_from_page')->name('me.search');

Route::put('/like/{me}', 'MeController@like')->name('like');