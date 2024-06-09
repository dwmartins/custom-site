<?php

use App\Http\Route;

include __DIR__ . '/userRouter.php';
include __DIR__ . '/productRouter.php';
include __DIR__ . '/selectedProjectRouter.php';
include __DIR__ . '/siteConfigRouter.php';
include __DIR__ . '/siteInfoRouter.php';

Route::get('/', 'HomeController@index');