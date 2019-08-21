<?php

namespace App\Modules\Coins\Providers;

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
        $this->loadTranslationsFrom(module_path('coins', 'Resources/Lang', 'app'), 'coins');
        $this->loadViewsFrom(module_path('coins', 'Resources/Views', 'app'), 'coins');
        $this->loadMigrationsFrom(module_path('coins', 'Database/Migrations', 'app'), 'coins');
        $this->loadConfigsFrom(module_path('coins', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('coins', 'Database/Factories', 'app'));
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
