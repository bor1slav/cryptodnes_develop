<?php

namespace App\Modules\Subscribers\Providers;

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
        $this->loadTranslationsFrom(module_path('subscribers', 'Resources/Lang', 'app'), 'subscribers');
        $this->loadViewsFrom(module_path('subscribers', 'Resources/Views', 'app'), 'subscribers');
        $this->loadMigrationsFrom(module_path('subscribers', 'Database/Migrations', 'app'), 'subscribers');
        $this->loadConfigsFrom(module_path('subscribers', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('subscribers', 'Database/Factories', 'app'));
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
