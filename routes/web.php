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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/threads','ThreadsController@index')->name('threads');

Route::any('/threads/{channel}/{thread}/edit','ThreadsController@edit');

Route::put('/threads/{channel}/{thread}/update','ThreadsController@update');

Route::put('/threads/{thread}/lock','LockThreadControllers@update');

Route::delete('replies/{reply}/unfavourite' , 'FavouriteController@destroy');

Route::delete('/threads/{thread}/unfavourite' , 'FavouriteController@destroy');

Route::get('/threads/create' , 'ThreadsController@create');

Route::get('/threads/{channel}','ThreadsController@index');

Route::get('/threads/{channel}/{thread}','ThreadsController@show');

Route::delete('/threads/{channel}/{thread}','ThreadsController@destroy');

Route::post('/threads','ThreadsController@store')->middleware('shoudConfirmYourEmail');

Route::post('/threads/{channel}/{thread}/replies','RepliesController@store')->middleware('shoudConfirmYourEmail');

Route::delete('/replies/{reply}','RepliesController@destroy');

Route::patch('/replies/{reply}','RepliesController@edit');

Route::put('/replies/{reply}','RepliesController@update');

Route::post('replies/{reply}/favourite' , 'FavouriteController@store');

Route::post('threads/{thread}/favourite' , 'FavouriteController@store');

Route::get('/profiles/{user}' , 'ProfilesController@show')->name('profile');

Route::post('/threads/{channel}/{thread}/subscribe','SubscribesController@store');

Route::delete('/threads/{channel}/{thread}/subscribe','SubscribesController@destroy');

Route::delete('/profiles/{user}/notifications/{notification}','NotificationsController@destroy');

Route::get('/profiles/{user}/notifications','NotificationsController@index');

Route::post('/users/{user}/avatar','AvatarsController@store')->middleware('auth')->name('avatar');

Route::get('/test' , 'ThreadsController@test');

Route::get('/register/confirm/{token}','UsersControllers@index');

Route::post('/replies/{reply}/best','RepliesController@bestReply');