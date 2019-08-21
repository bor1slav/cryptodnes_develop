<?php

namespace App\Modules\Sitemaps\Providers;

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
        $this->loadTranslationsFrom(module_path('sitemaps', 'Resources/Lang', 'app'), 'sitemaps');
        $this->loadViewsFrom(module_path('sitemaps', 'Resources/Views', 'app'), 'sitemaps');
        $this->loadMigrationsFrom(module_path('sitemaps', 'Database/Migrations', 'app'), 'sitemaps');
        $this->loadConfigsFrom(module_path('sitemaps', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('sitemaps', 'Database/Factories', 'app'));
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
