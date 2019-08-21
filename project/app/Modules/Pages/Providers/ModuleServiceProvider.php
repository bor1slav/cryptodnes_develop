<?php

namespace App\Modules\Pages\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('pages', 'Resources/Lang', 'app'), 'pages');
        $this->loadViewsFrom(module_path('pages', 'Resources/Views', 'app'), 'pages');
        $this->loadMigrationsFrom(module_path('pages', 'Database/Migrations', 'app'), 'pages');
        $this->loadConfigsFrom(module_path('pages', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('pages', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
