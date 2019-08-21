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
//        'prefix' => 'sitemaps',
    'as' => 'sitemaps.'
], function () {

    Route::get('/sitemap.xml', [
        'as' => 'sitemap',
        'uses' => 'SitemapController@index'
    ]);

    Route::get('/site.xml', [
        'as' => 'site',
        'uses' => 'SitemapController@site'
    ]);

    Route::get('/categories.xml', [
        'as' => 'categories',
        'uses' => 'SitemapController@categories'
    ]);

    Route::get('/articles.xml', [
        'as' => 'articles',
        'uses' => 'SitemapController@articles'
    ]);

    Route::get('/analyzes.xml', [
        'as' => 'analyzes',
        'uses' => 'SitemapController@analyzes'
    ]);


    Route::get('/coins.xml', [
        'as' => 'coins',
        'uses' => 'SitemapController@coins'
    ]);


});
