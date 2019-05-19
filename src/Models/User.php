<?php

namespace Sevenpluss\LaravelTwitchApi\Models;

use App\User as AppUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class User
 *
 * @package Sevenpluss\LaravelTwitchApi\Models
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $twitch_id
 * @property string|null $tw_refresh_token
 * @property string|null $tw_access_token
 * @property string|null $profile_image_url
 * @property string|null $tw_favorite_streamer
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail(string $value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId(int $value)
 * @method static Builder|User whereName(string $value)
 * @method static Builder|User wherePassword(string $value)
 * @method static Builder|User whereProfileImageUrl(string $value)
 * @method static Builder|User whereRememberToken(string $value)
 * @method static Builder|User whereTwAccessToken(string $value)
 * @method static Builder|User whereTwRefreshToken(string $value)
 * @method static Builder|User whereTwitchId(string $value)
 * @method static Builder|User whereTwFavoriteStreamer(string $value)
 * @method static Builder|User whereUpdatedAt(Carbon|string $value)
 */
class User extends AppUser
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'twitch_id',
        'tw_refresh_token',
        'tw_access_token',
        'profile_image_url',
        'tw_favorite_streamer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',

        'twitch_id' => 'string',
        'tw_refresh_token' => 'string',
        'tw_access_token' => 'string',
        'profile_image_url' => 'string',
        'tw_favorite_streamer' => 'string',

        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name' => null
    ];
}
