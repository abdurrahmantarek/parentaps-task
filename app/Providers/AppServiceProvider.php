<?php

namespace App\Providers;

use App\Http\DataProviders\DataProviderConfig;
use App\Http\DataProviders\DataProviderX;
use App\Http\DataProviders\DataProviderY;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        DataProviderConfig::init();

        $this->app->bind(DataProviderX::class, function ($app) {
            return new DataProviderX(DataProviderConfig::$dpFilePathX);
        });
        $this->app->bind(DataProviderY::class, function ($app) {
            return new DataProviderY(DataProviderConfig::$dpFilePathY);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
