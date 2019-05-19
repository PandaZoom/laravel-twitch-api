# Authorization

[Twitch API](https://github.com/sevenpluss/laravel-twitch-api#documentation)


## Functions


## Example Usage

Add route for twitch response in your `routes/web.php`
```php
<?php
// Twitch callback route
Route::get('callback', ['as'=>'twitchCallback', 'uses'=>'LoginController@twitchCallback']);
```

Auth user by Twitch Api, add method `twitchCallback` for twitch response in your `LoginController` 

```php
<?php

namespace App\Http\Controllers\Auth;

use Sevenpluss\TwitchApi\Services\Twitch;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $streamer = $this->validateRequestLogin($request);

        $request->session()->put('streamer', $streamer);

        return redirect()->to(app()->make(TwitchAuth::class)->getAuthUri());
    }

    public function twitchCallback(Request $request, Twitch $twitch)
    {
        // return user model with filled fields
        $user = $twitch->auth()->authUser($request);
        
        // ...
        // next operations with user model
        // ...
        
        // require save model
        $user->save();
        
        auth()->login($user);
        
        return redirect()->route('your_page_route');
    } 
}
```
