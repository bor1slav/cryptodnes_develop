<?php

namespace Charlotte\Administration\Providers;


use Charlotte\Administration\Commands\MigrateCommand;
use Charlotte\Administration\Http\Models\Admin;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AdministrationServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        //Fix utf8mb4 collation
        Schema::defaultStringLength(191);


        //Setup Commands
        //TODO get all classes from commands folder and add them to array
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrateCommand::class,
            ]);
        }

        //Setup Guard
        Config::set([
            'auth.guards.' . config('administration.guard') => [
                'driver' => 'session',
                'provider' => config('administration.guard'),
            ],
        ]);
        Config::set([
            'auth.providers.' . config('administration.guard') => [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ],
        ]);


        //Load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations/');

        //Load Routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');

        //Load Views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'administration');

        //Load Translations
        $this->loadTranslationsFrom(resource_path('lang/charlotte'), 'administration');

        //Load Configs
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/administration.php', 'administration'
        );


        //Publish Lang
        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/charlotte'),
        ], 'Charlotte/lang');

        //Publish Configs
        $this->publishes([
            __DIR__ . '/../../config/administration.php' => config_path('administration.php'),
            __DIR__ . '/../../config/laravel-form-builder.php' => config_path('laravel-form-builder.php'),
            __DIR__ . '/../../config/laravellocalization.php' => config_path('laravellocalization.php'),
            __DIR__ . '/../../config/translatable.php' => config_path('translatable.php'),
        ], 'Charlotte/config');

        //Publish Views
        $this->publishes([
            __DIR__ . '/../../resources/assets/' => public_path('charlotte/administration'),
        ], 'Charlotte/public');


    }


}
