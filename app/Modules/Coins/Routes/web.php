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

Route::group([
    'prefix' => 'kripto-valuti',
    'as' => 'coins.'
], function () {

    Route::get('/', [
        'as' => 'index',
        'uses' => 'CoinsController@index',
    ]);

    Route::get('/{slug}', [
        'as' => 'view',
        'uses' => 'CoinsController@view',
    ]);
});

Route::group([
    'prefix' => 'coins',
    'as' => 'oldCoins.'
], function () {

    Route::get('/', [
        'as' => 'redirectIndex',
        'uses' => 'CoinsController@redirectIndex',
    ]);

    Route::get('/{slug}', [
        'as' => 'view',
        'uses' => 'CoinsController@redirectView',
    ]);
});


//Route::get('/coins', [
//    'as' => 'redirectIndex',
//    'uses' => 'CoinsController@redirectIndex',
//]);
