<?php

use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\Users')
    ->middleware('json.response')
    ->prefix('users')
    ->group(function () {
        Route::put('create-user', 'UserController@createUser');
        Route::delete('remove-user/{id}', 'UserController@removeUser');
        Route::get('get-user/{id}', 'UserController@getUser');
        Route::patch('update-user', 'UserController@updateUser');
    });
