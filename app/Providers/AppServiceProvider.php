<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// app/Providers/AppServiceProvider.php
use App\Services\SensorService;
use App\Services\VolumeCalculationService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SensorService::class, function ($app) {
            return new SensorService();
        });

        $this->app->singleton(VolumeCalculationService::class, function ($app) {
            return new VolumeCalculationService();
        });
    }
}
