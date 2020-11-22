<?php

use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\Users')
    ->middleware('json.response')
    ->prefix('users')
    ->group(function () {
        Route::put('create-user', 'UserController@createUser');
        Route::delete('remove-user/{id}', 'UserController@removeUser')
            ->where('id', '[0-9]+');
        Route::get('get-user/{id}', 'UserController@getUser')
            ->where('id', '[0-9]+');
        Route::patch('update-user', 'UserController@updateUser');
    });

Route::namespace('App\Http\Controllers\Events')
    ->middleware('json.response')
    ->prefix('events')
    ->group(function () {
        Route::put('create-event', 'EventController@createEvent');
        Route::delete('remove-event/{id}', 'EventController@removeEvent')
            ->where('id', '[0-9]+');
        Route::get('get-event/{id}', 'EventController@getEvent')
            ->where('id', '[0-9]+');
        Route::patch('update-event', 'EventController@updateEvent');
    });
