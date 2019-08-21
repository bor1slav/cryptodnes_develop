<?php

namespace App\Modules\Analyzes\Providers;

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
        $this->loadTranslationsFrom(module_path('analyzes', 'Resources/Lang', 'app'), 'analyzes');
        $this->loadViewsFrom(module_path('analyzes', 'Resources/Views', 'app'), 'analyzes');
        $this->loadMigrationsFrom(module_path('analyzes', 'Database/Migrations', 'app'), 'analyzes');
        $this->loadConfigsFrom(module_path('analyzes', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('analyzes', 'Database/Factories', 'app'));
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
