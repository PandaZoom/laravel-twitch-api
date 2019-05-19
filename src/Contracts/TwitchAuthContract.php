<?php

namespace Sevenpluss\LaravelTwitchApi\Contracts;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Sevenpluss\TwitchApi\Exceptions\AuthenticationException;
use Sevenpluss\TwitchApi\Exceptions\ClientIdMissingException;
use Sevenpluss\TwitchApi\Exceptions\ClientSecretMissingException;
use Sevenpluss\TwitchApi\Exceptions\NotFoundResourceException;
use Sevenpluss\TwitchApi\Exceptions\TokenMissingException;
use Sevenpluss\TwitchApi\Exceptions\UriMissingException;
use Sevenpluss\LaravelTwitchApi\Models\User;

/**
 * Interface TwitchAuthContract
 *
 * @package Sevenpluss\LaravelTwitchApi\Contracts
 * @link    https://dev.twitch.tv/docs/authentication/getting-tokens-oauth/#introduction
 */
interface TwitchAuthContract
{
    /**
     * Get url for authorization by Twitch
     *
     * @param array $scopes
     * @param bool $forceLogin
     *
     * @return string
     * @throws Exception
     */
    public function getAuthUri(array $scopes = [], bool $forceLogin = false): string;

    /**
     * Get currently auth user with Bearer Token
     * Note: Bearer OAuth Token is required
     *
     * @link  https://dev.twitch.tv/docs/authentication/getting-tokens-oauth/#oauth-authorization-code-flow
     *
     * @param Request $request
     *
     * @return User
     * @throws AuthenticationException
     * @throws NotFoundResourceException
     * @throws GuzzleException
     * @throws BindingResolutionException
     * @throws ClientIdMissingException
     * @throws ClientSecretMissingException
     * @throws TokenMissingException
     * @throws UriMissingException
     */
    public function authUser(Request $request): User;

    /**
     * Refresh the user token
     *
     * @link  https://dev.twitch.tv/docs/authentication/#refreshing-access-tokens
     *
     * @param string $refreshToken
     * @param array $scopes
     *
     * @return array|null
     * @throws ClientIdMissingException
     * @throws ClientSecretMissingException
     * @throws GuzzleException
     * @throws TokenMissingException
     */
    public function refreshToken(string $refreshToken, array $scopes = []): ?array;
}
