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
    'prefix' => 'novini',
    'as' => 'blog.'
], function () {

    Route::post('/comment/store', [
        'as' => 'store_comment',
        'uses' => 'BlogController@StoreComment',
    ]);

//    Route::post('/changeArticlesData', [
//        'as' => 'changeArticlesData',
//        'uses' => 'BlogController@changeArticlesData',
//    ]);

    Route::get('/{slug}', [
        'as' => 'index',
        'uses' => 'BlogController@index',
    ]);




});

Route::get('/{article_slug}', [
    'as' => 'blog.view',
    'uses' => 'BlogController@view',
]);

Route::group([
    'prefix' => 'tags',
    'as' => 'tags.'
], function () {

//    Route::post('/changeArticlesData', [
//        'as' => 'changeArticlesData',
//        'uses' => 'TagsController@changeArticlesData',
//    ]);

    Route::get('/{slug}', [
        'as' => 'index',
        'uses' => 'TagsController@index',
    ]);

});
