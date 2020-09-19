<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('profile', 'ProfileController')->only(['edit','update']);

Route::resource('me', 'MeController')->only(['show']);
Route::get('/me/search/store', 'MeController@store_from_search')->name('me.search.store');
Route::get('/me/{me}/refresh', 'MeController@refresh')->name('me.refresh');
Route::put('/me/{me}/like', 'MeController@like')->name('me.like');
Route::put('/me/{me}/emotions', 'MeController@emotions')->name('me.emotions');
Route::put('/me/{me}/stars', 'MeController@stars')->name('me.stars');

Route::resource('season', 'SeasonController')->only(['show']);
Route::put('/season/{season}/like', 'SeasonController@like')->name('season.like');
Route::put('/season/{season}/emotions', 'SeasonController@emotions')->name('season.emotions');
Route::put('/season/{season}/stars', 'SeasonController@stars')->name('season.stars');

Route::get('/test', 'MeController@get_information_from_page')->name('me.search');