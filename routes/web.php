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

Auth::routes();


Route::get('/', 'HomeController@welcome')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/pusher/auth', 'HomeController@pusherAuth')->name('pusher.auth');

Route::get('/logout', 'HomeController@logout')->name('logout');


Route::get('/conversation/{recipient_id}', 'MessageController@newConversation')->name('conversation.new');

Route::post('/message/new', 'MessageController@newMessage')->name('message.new');

Route::post('/message/trigger', 'MessageController@triggerMessage')->name('message.trigger');

Route::get('/messages/unread', 'MessageController@unreadMessages')->name('messages.unread');

Route::post('/messages/read', 'MessageController@markAsRead');


Route::post('/search', 'UserController@search')->name('search');

Route::get('contact/{id}/new', 'ContactController@new')->name('contact.new');

Route::delete('contact/{user_id}/delete', 'ContactController@delete')->name('contact.delete');

Route::get('/user/edit', 'UserController@edit')->name('user.edit');

Route::post('/user/save', 'UserController@save')->name('user.save');

Route::get('user/{id}/show', 'UserController@show')->name('user.show');
