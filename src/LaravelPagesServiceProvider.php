<?php

namespace Sideapps\LaravelPages;

use Illuminate\Support\ServiceProvider;
use Sideapps\LaravelPages\Console\Commands\CreateDynamicPageCommand;
use Sideapps\LaravelPages\Console\Commands\CreateStaticPageCommand;

class LaravelPagesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfiguration();
        $this->registerCommands();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->publishConfiguration();
    }

    private function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelPage');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravelPage'),
        ]);
    }

    private function publishConfiguration()
    {
        $this->publishes([
            __DIR__.'/../config/page.php' => config_path('page.php'),
        ], 'config');
    }

    private function mergeConfiguration()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/page.php', 'page');
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateStaticPageCommand::class,
                CreateDynamicPageCommand::class
            ]);
        }
    }
}
