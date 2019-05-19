<?php

namespace Sevenpluss\LaravelTwitchApi\Providers;

use Illuminate\Support\ServiceProvider;
use Sevenpluss\LaravelTwitchApi\Contracts\TwitchAuthContract;
use Sevenpluss\LaravelTwitchApi\Services\DefaultClientSettings;
use Sevenpluss\LaravelTwitchApi\Services\TwitchAuth;
use Sevenpluss\TwitchApi\Contracts\ResultContract;
use Sevenpluss\TwitchApi\Contracts\TwitchApiContract;
use Sevenpluss\TwitchApi\Services\Result;
use Sevenpluss\TwitchApi\Services\TwitchApi;

/**
 * Class TwitchServiceProvider
 *
 * @package Sevenpluss\LaravelTwitchApi\Providers
 */
class TwitchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/twitch_api.php' => config_path('twitch_api.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bindIf(ResultContract::class, Result::class, true);

        $this->app->bindIf(TwitchApiContract::class, function (){
            $settings = new DefaultClientSettings;
            return new TwitchApi($settings);
        }, true);

        $this->app->bindIf(TwitchAuthContract::class, TwitchAuth::class, true);
    }
}
