# Laravel Twitch Api

[![Latest Stable Version](https://img.shields.io/packagist/v/sevenpluss/laravel-twitch-api.svg?style=flat-square)](https://packagist.org/packages/sevenpluss/laravel-twitch-api)
[![Total Downloads](https://img.shields.io/packagist/dt/sevenpluss/laravel-twitch-api.svg?style=flat-square)](https://packagist.org/packages/sevenpluss/laravel-twitch-api)
[![License](https://img.shields.io/packagist/l/sevenpluss/laravel-twitch-api.svg?style=flat-square)](https://packagist.org/packages/sevenpluss/laravel-twitch-api)

[PHP Twitch Api](https://github.com/sevenpluss/twitch-api) Wrapper for Laravel 5+

[Demo Link](https://herokutop.com) with few api elements.

**NOTICE: This library uses the latest Twitch HELIX API which ist not fully featured yet**

## Table of contents

1. [Installation](https://github.com/sevenpluss/laravel-twitch-api#installation)
2. [Configuration](https://github.com/sevenpluss/laravel-twitch-api#configuration)
3. [Documentation](https://github.com/sevenpluss/twitch-api#documentation)

## Installation

```
composer require sevenpluss/laravel-twitch-api
```

Or add `sevenpluss/laravel-twitch-api` to your `composer.json`

```
"sevenpluss/laravel-twitch-api": "^1.0"
```

Run `composer update` to pull the latest version.

Add Service Provider to your `config/app.php` file:
**If you use Laravel 5.5+ you are already done, leave this step and go next**

```
Sevenpluss\LaravelTwitchApi\Providers\TwitchServiceProvider::class,
```

## Configuration

Copy configuration to config folder:

```
$ php artisan vendor:publish --provider="Sevenpluss\LaravelTwitchApi\Providers\TwitchServiceProvider"
```

Add the User model to your `config/auth.php` file:
```
//...
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => config('twitch_api.user_model'),
        ],
//...
```

Add environmental variables to your `.env`

```
TWITCH_CLIENT_ID=
TWITCH_CLIENT_SECRET=
TWITCH_REDIRECT_URI=http://localhost
```

## Documentation

All documentation how to use [Twitch Api](https://github.com/sevenpluss/twitch-api) you can obtain [here](https://github.com/sevenpluss/twitch-api#documentation)
