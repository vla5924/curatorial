<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\VkTokenService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class VkLoginController extends Controller
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
        $avatar = $oauthUser->getAvatar();
        $token = $oauthUser->accessTokenResponseBody['access_token'];
        $expires = (int)floor($oauthUser->accessTokenResponseBody['expires_in'] / 60);
        $user = User::where(['vk_id' => $id])->first();
        if ($user) {
            $user->fill([
                'name' => $name,
                'avatar' => $avatar,
            ]);
        } else {
            $user = User::create([
                'vk_id' => $id,
                'name' => $name,
                'avatar' => $avatar,
            ]);
            $user->assignRole('noname');
        }
        if ($user) {
            Auth::loginUsingId($user->id);
            VkTokenService::setToken($token, $expires);
            return redirect()->route('home');
        }
        return back(400);
    }
}
