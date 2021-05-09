<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Cookie;

class VKTokenService
{
    const COOKIE_NAME = 'VKONTAKTE_USER_TOKEN';

    public static function setToken(string $token, int $expires = 1440)
    {
        Cookie::queue(self::COOKIE_NAME, $token, $expires);
    }

    public static function removeToken()
    {
        Cookie::queue(self::COOKIE_NAME, '', -1);
    }

    public static function getToken()
    {
        return Cookie::get(self::COOKIE_NAME, '');
    }
}
