<?php

namespace NavrajSharma\SparrowSMS;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SparrowSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sparrowsms', function ($app) {
                return new SparrowSMSChannel(config('sparrowsms'));
            });
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sparrowsms.php', 'sparrowsms');

        $this->publishes([
            __DIR__.'/../config/sparrowsms.php' => config_path('sparrowsms.php'),
        ]);
    }
}
