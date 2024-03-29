<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', [
    'as' => 'index',
    'uses' => 'IndexController@index',
]);

Route::get('/search', [
    'as' => 'search',
    'uses' => 'IndexController@search',
]);