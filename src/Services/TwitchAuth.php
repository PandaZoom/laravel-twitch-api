<?php

namespace Sevenpluss\LaravelTwitchApi\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Sevenpluss\LaravelTwitchApi\Contracts\TwitchAuthContract;
use Sevenpluss\LaravelTwitchApi\Models\User;
use Sevenpluss\TwitchApi\Contracts\TwitchApiContract;
use Sevenpluss\TwitchApi\Exceptions\AuthenticationException;
use Sevenpluss\TwitchApi\Exceptions\ClientIdMissingException;
use Sevenpluss\TwitchApi\Exceptions\ClientSecretMissingException;
use Sevenpluss\TwitchApi\Exceptions\NotFoundResourceException;
use Sevenpluss\TwitchApi\Exceptions\TokenMissingException;
use Sevenpluss\TwitchApi\Exceptions\UriMissingException;

/**
 * Class TwitchAuth
 *
 * @package Sevenpluss\LaravelTwitchApi\Services
 */
class TwitchAuth implements TwitchAuthContract
{
    /**
     * @var TwitchApiContract
     */
    protected $api;

    /**
     * TwitchAuth constructor.
     *
     * @param TwitchApiContract $api
     *
     * @return void
     */
    public function __construct(TwitchApiContract $api)
    {
        $this->api = $api;
    }

    /**
     * @inheritDoc
     */
    public function getAuthUri(array $scopes = [], bool $forceLogin = false): string
    {
        $state = $this->api->request()->getState();

        session()->put('twitch_state', $state);

        if (!$scopes && config('twitch_api.scopes')) {
            $scopes = config('twitch_api.scopes');
        }

        return $this->api->request()->getAuthUri($state, $scopes, $forceLogin);
    }

    /**
     * @inheritDoc
     */
    public function authUser(Request $request): User
    {
        $response = $this->handleResponse($request);

        if (is_null($response)) {
            throw new AuthenticationException;
        }

        $users = $this->api->request()->get('users');

        if (!$users->success() || !is_array($users->data()) || !isset($users->data()[0])) {
            throw new NotFoundResourceException('Twitch User');
        }

        // update properties in User model
        $user = app(config('twitch_api.user_model'))->firstOrNew([config('twitch_api.user_keys.id') => $users->data()[0]['id']]);

        foreach (config('twitch_api.user_keys') as $key => $value) {
            if ($value) {
                if ($key == 'refresh_token' || $key == 'access_token') {
                    $user->{$value} = $response[$key];
                } else {
                    $user->{$value} = $users->data()[0][$key];
                }
            }
        }

        // return User model, but then you should to call method save()
        // after finished the all manipulations with this model
        return $user;
    }

    /**
     * @param string $refreshToken
     * @param array $scopes
     *
     * @return array|null
     * @throws ClientIdMissingException
     * @throws ClientSecretMissingException
     * @throws GuzzleException
     * @throws TokenMissingException
     */
    public function refreshToken(string $refreshToken, array $scopes = []): ?array
    {
        $response = $this->api->request()->refreshToken($refreshToken, $scopes);

        if (!$response->success()) {
            return null;
        }

        if (auth()->check()) {

            $user = auth()->user();

            if (config('twitch_api.user_keys.refresh_token')) {
                $user->{config('twitch_api.user_keys.refresh_token')} = $response->data()['refresh_token'];
            }

            if (config('twitch_api.user_keys.access_token')) {
                $user->{config('twitch_api.user_keys.access_token')} = $response->data()['access_token'];
            }

            $user->save();
        }

        return $response->data();
    }

    /**
     * Handle the response from twitch
     *
     * @param Request $request
     *
     * @return array|null
     * @throws ClientIdMissingException
     * @throws ClientSecretMissingException
     * @throws GuzzleException
     * @throws TokenMissingException
     * @throws UriMissingException
     */
    protected function handleResponse(Request $request): ?array
    {
        $code = $request->input('code');
        $state = $request->input('state');

        if ($state !== session()->get('twitch_state') || !$code || !$state) {
            return null;
        }

        session()->forget('twitch_state');

        $response = $this->api->request()->getAuthToken($code);

        if (!$response->success()) {
            return null;
        }

        $this->api->request()->setToken($response->data()['access_token']);

        return $response->data();
    }
}
