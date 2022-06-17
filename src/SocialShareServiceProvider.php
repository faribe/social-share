<?php

namespace Faribe\SocialShare;

use Faribe\SocialShare\SocialShare;
use Illuminate\Support\ServiceProvider;

class SocialShareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/social-share.php' => config_path('social-share.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../public/js/social-share.js' => public_path('js/social-share.js'),
        ], 'assets');
        
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(SocialShare::class, function () {
            return new SocialShare();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/social-share.php', 'social-share');
    }
}
