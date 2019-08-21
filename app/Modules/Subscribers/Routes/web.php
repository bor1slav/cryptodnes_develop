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
    'prefix' => 'subscribers',
    'as' => 'subscribers.'
], function () {

    Route::post('/store', [
        'as' => 'store',
        'uses' => 'SubscribersController@store',
    ]);

    Route::post('/storeBookSubscribe', [
        'as' => 'storeBookSubscribe',
        'uses' => 'SubscribersController@storeBookSubscription',
    ]);

    Route::get('/unsubscribe/{email}', [
        'as' => 'unsubscribe',
        'uses' => 'SubscribersController@unsubscribe',
    ]);

});
