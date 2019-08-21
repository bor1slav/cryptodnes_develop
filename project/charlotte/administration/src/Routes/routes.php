<?php


use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Middleware\AdministratorLogged;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Charlotte\Administration\Helpers\AdministrationModuleHelper;


Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => Administration::getMiddlewares(),
    'as' => 'administration.',
], function () {
    Route::group([

    ], function () {

        //Administration routes
        Route::group([
            'namespace' => 'Charlotte\Administration\Http\Controllers',
        ], function () {
            Route::group([
                'middleware' => AdministratorLogged::class

            ], function () {
                Route::get('/', [
                    'as' => 'index',
                    'uses' => 'DashboardController@index',
                ]);

                Route::get('/logs', [
                    'as' => 'logs',
                    'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index',
                ]);

                Route::resource('admins', 'AdministratorsController');

                Route::get('/settings', [
                    'as' => 'settings',
                    'uses' => 'SettingsController@index',
                ]);

                Route::post('/settings/store', [
                    'as' => 'settings.store',
                    'uses' => 'SettingsController@store',
                ]);

                //ajax
                Route::post('/settings/change-color', [
                    'as' => 'change_color',
                    'uses' => 'AjaxController@changeColor',
                ]);

                Route::post('/quick_switch', [
                    'as' => 'quick_switch',
                    'uses' => 'AjaxController@saveQuickSwitch',
                ]);

                Route::post('/quick_file', [
                    'as' => 'quick_file',
                    'uses' => 'AjaxController@quickUploadFile',
                ]);

                Route::post('/quick_delete_file', [
                    'as' => 'quick_delete_file',
                    'uses' => 'AjaxController@quickDeleteFile',
                ]);

                Route::post('/quick_reorder', [
                    'as' => 'quick_reorder',
                    'uses' => 'AjaxController@quickReorder',
                ]);

                Route::post('/quick_media_reorder', [
                    'as' => 'quick_media_reorder',
                    'uses' => 'AjaxController@quickMediaSort',
                ]);

            });

            // Authentication Routes...
            Route::get('login', [
                'as' => 'login',
                'uses' => 'Auth\LoginController@showLoginForm',
            ]);

            Route::post('login', [
                'as' => 'login',
                'uses' => 'Auth\LoginController@login',
            ]);

            Route::get('logout', 'Auth\LoginController@logout')->name('logout');
        });

        Route::group([
            'middleware' => AdministratorLogged::class

        ], function () {
            //Import all module routes
            AdministrationModuleHelper::moduleRoutes();
        });





    });
});
