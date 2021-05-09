<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\VKTokenService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class VKLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('vkontakte')->scopes(['email', 'photos', 'video', 'groups'])->redirect();
    }

    public function callback()
    {
        $oauthUser = Socialite::driver('vkontakte')->user();
        $email = $oauthUser->getEmail();
        $name = $oauthUser->getName();
        $token = $oauthUser->accessTokenResponseBody['access_token'];
        $expires = (int)floor($oauthUser->accessTokenResponseBody['expires_in'] / 60);
        $user = User::where(['email' => $email])->first();
        if ($user) {
            $user->fill(['name' => $name]);
        } else {
            $user = User::create([
                'email' => $email,
                'name' => $name,
            ]);
        }
        if ($user) {
            Auth::loginUsingId($user->id);
            VKTokenService::setToken($token, $expires);
            return redirect()->route('practices');
        }
        return back(400);
    }
}
