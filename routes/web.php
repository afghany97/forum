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

Route::get('/threads/{thread}/edit/history' , 'ModifyController@show')->name('thread.history');

Route::get('/threads','ThreadsController@index')->name('threads');

Route::match(['patch','get' , 'put'],'/threads/{channel}/{thread}/edit','ThreadsController@edit')->name('thread.edit');

Route::put('/threads/{channel}/{thread}/update','ThreadsController@update')->name('thread.update');

Route::put('/threads/{thread}/lock','LockThreadControllers@update')->name('thread.lockToggle');

Route::delete('replies/{reply}/unfavourite' , 'FavouriteController@destroy')->name('reply.unfavourite');

Route::delete('/threads/{thread}/unfavourite' , 'FavouriteController@destroy')->name('thread.unfavourite');

Route::get('/threads/create' , 'ThreadsController@create')->name('thread.create');

Route::get('/threads/{channel}','ThreadsController@index')->name('channel.show');

Route::get('/threads/{channel}/{thread}','ThreadsController@show')->name('thread.show');

Route::delete('/threads/{channel}/{thread}','ThreadsController@destroy')->name('thread.destroy');

Route::post('/threads','ThreadsController@store')->middleware('shouldConfirmYourEmail')->name('thread.store');

Route::post('/threads/{channel}/{thread}/replies','RepliesController@store')->middleware('shouldConfirmYourEmail')->name('reply.store');

Route::delete('/replies/{reply}','RepliesController@destroy')->name('reply.destroy');

Route::patch('/replies/{reply}','RepliesController@edit')->name('reply.edit');

Route::put('/replies/{reply}','RepliesController@update')->name('reply.update');

Route::post('replies/{reply}/favourite' , 'FavouriteController@store')->name('reply.favourite');

Route::post('threads/{thread}/favourite' , 'FavouriteController@store')->name('thread.favourite');

Route::get('/profiles/{user}' , 'ProfilesController@show')->name('profile');

Route::post('/threads/{channel}/{thread}/subscribe','SubscribesController@store')->name('thread.subscribe');

Route::delete('/threads/{channel}/{thread}/subscribe','SubscribesController@destroy')->name('thread.unsubscribe');

Route::delete('/profiles/{user}/notifications/{notification}','NotificationsController@destroy')->name('user.notifications.destroy');

Route::get('/profiles/{user}/notifications','NotificationsController@index')->name('user.notifications');

Route::post('/users/{user}/avatar','AvatarsController@store')->middleware('auth')->name('avatar');

Route::get('/register/confirm/{token}','UsersControllers@index')->name('user.confirm');

Route::post('/replies/{reply}/best','RepliesController@bestReply')->name('reply.best');

Route::get('/admin/control' , 'AdminsController@index')->name('dashboard');

Route::get('/admin/control/users' , 'AdminsController@showUsers')->name('dashboard.users');

Route::get('/admin/control/threads' , 'AdminsController@showThreads')->name('dashboard.threads');

Route::post('/users/{user}/supervisor' , 'SupervisorController@store')->name('user.supervisor');

Route::match(['patch','get' , 'put'],'/profiles/{user}/edit' , 'ProfilesController@edit')->name('profile.edit');

Route::put('/profiles/{user}/update' , 'ProfilesController@update')->name('profile-update');
