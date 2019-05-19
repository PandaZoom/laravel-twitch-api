<?php

namespace Sevenpluss\LaravelTwitchApi\Services;

use Sevenpluss\TwitchApi\Services\ClientSettings;

/**
 * Class DefaultClientSettings
 *
 * @package Sevenpluss\LaravelTwitchApi\Services
 */
class DefaultClientSettings extends ClientSettings
{
    /**
     * StreamerTwitchSettings constructor.
     * @param string|null $clientId
     * @return void
     */
    public function __construct(string $clientId = null)
    {
        if (is_null($clientId)) {
            $clientId = config('twitch_api.client_id');
        }

        $clientSecret = config('twitch_api.client_secret');
        $redirectUri = config('twitch_api.redirect_url');

        parent::__construct($clientId, $clientSecret, $redirectUri);
    }
}
