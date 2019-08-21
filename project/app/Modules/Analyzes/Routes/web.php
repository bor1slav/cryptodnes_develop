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
    'prefix' => 'analizi',
    'as' => 'analyzes.'
], function () {

    Route::post('/comment/store', [
        'as' => 'store_comment',
        'uses' => 'AnalyzesController@StoreComment',
    ]);

//    Route::post('/changeArticlesData', [
//        'as' => 'changeArticlesData',
//        'uses' => 'AnalyzesController@changeArticlesData',
//    ]);


    Route::get('/{slug?}', [
        'as' => 'index',
        'uses' => 'AnalyzesController@index',
    ]);

    Route::get('/{category_slug}/{article_slug}', [
        'as' => 'view',
        'uses' => 'AnalyzesController@view',
    ]);
});
