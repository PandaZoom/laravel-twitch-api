<?php

use Sevenpluss\LaravelTwitchApi\Models\User;

/**
 * @file twitch_api
 */

return [
    'client_id' => env('TWITCH_CLIENT_ID'),
    'client_secret' => env('TWITCH_CLIENT_SECRET'),
    'redirect_url' => env('TWITCH_REDIRECT_URI'),
    'user_keys' => [
        'id' => 'twitch_id',
        'refresh_token' => 'tw_refresh_token',
        'access_token' => 'tw_access_token',
        'profile_image_url' => 'profile_image_url',
        'display_name' => 'name'
    ],
    'user_model'=> User::class,
    'scopes'=> [
        'analytics:read:extensions',
        'analytics:read:games',
        'bits:read',
        'channel:read:subscriptions',
        'clips:edit',
        'user:edit',
        'user:edit:broadcast',
        'user:read:broadcast',
        'user:read:email',
    ],
];
