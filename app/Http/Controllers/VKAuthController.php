<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;

class VKAuthController extends Controller
{
    public function redirect()
    {
        //$clientId = '6322083';
        //$clientSecret = '4wX7cUNnWrSs2WSQT1PR';
        //$redirectUrl = 'http://localhost:8000/api/redirect';
        //$additionalProviderConfig = ['scope' => 'meta.stackoverflow.com'];
        //$config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
        //return Socialite::driver('vkontakte')->setConfig($config)->redirect();
        return Socialite::driver('vkontakte')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('vkontakte')->user();
        print_r($user);
        $email = $user->getEmail();
        $name = $user->getName();
        $token = $user->accessTokenResponseBody['access_token'];
        $expires = (int)floor($user->accessTokenResponseBody['expires_in'] / 60);
        $u = User::where(['email' => $email])->first();
        if ($u) {
            $u->fill(['name' => $name]);
        } else {
            $u = User::create([
                'email' => $email,
                'password' => '123',
                'name' => $name,
            ]);
        }
        if ($u) {
            Auth::login($u);
            Cookie::queue('VKONTAKTE_USER_TOKEN', $token, $expires);
            return redirect()->route('practices');
        }
        return back(400);
    }
}
