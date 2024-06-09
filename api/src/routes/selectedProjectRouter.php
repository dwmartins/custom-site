<?php

use App\Http\Route;

Route::post('/selectedproject/create', 'SelectedProjectsController@create');
Route::get('/selectedproject/fetch', 'SelectedProjectsController@fetch');