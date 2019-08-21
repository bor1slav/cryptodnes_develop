<?php

namespace App\Modules\Contacts\Providers;

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
        $this->loadTranslationsFrom(module_path('contacts', 'Resources/Lang', 'app'), 'contacts');
        $this->loadViewsFrom(module_path('contacts', 'Resources/Views', 'app'), 'contacts');
        $this->loadMigrationsFrom(module_path('contacts', 'Database/Migrations', 'app'), 'contacts');
        $this->loadConfigsFrom(module_path('contacts', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('contacts', 'Database/Factories', 'app'));
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
