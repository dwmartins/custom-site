<?php

use App\Http\Route;

Route::post('/users/create', 'UserController@create');
Route::post('/users/login', 'UserController@login');
Route::get('/users/fetch', 'UserController@fetch');
Route::put('/users/update', 'UserController@update');
Route::delete('/users/delete/{id}', 'UserController@remove');

Route::get('/users/auth', 'UserController@auth');