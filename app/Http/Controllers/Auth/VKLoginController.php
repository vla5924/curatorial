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
        return Socialite::driver('vkontakte')->scopes(['photos', 'video', 'groups'])->redirect();
    }

    public function callback()
    {
        $oauthUser = Socialite::driver('vkontakte')->user();
        $id = $oauthUser->getId();
        $name = $oauthUser->getName();
        $token = $oauthUser->accessTokenResponseBody['access_token'];
        $expires = (int)floor($oauthUser->accessTokenResponseBody['expires_in'] / 60);
        $user = User::where(['vk_id' => $id])->first();
        if ($user) {
            $user->fill(['name' => $name]);
        } else {
            $user = User::create([
                'vk_id' => $id,
                'name' => $name,
            ]);
            $user->assignRole('noname');
        }
        if ($user) {
            Auth::loginUsingId($user->id);
            VKTokenService::setToken($token, $expires);
            return redirect()->route('home');
        }
        return back(400);
    }
}
