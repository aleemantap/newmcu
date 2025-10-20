<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register helper classes
        $this->app->bind('reporthelp', function() {
            return new \App\Helpers\ReportHelp();
        });

         // Register helper classes
        $this->app->bind('setting', function() {
            return new \App\Helpers\Setting();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
