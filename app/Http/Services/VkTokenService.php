<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Cookie;

class VkTokenService
{
    const COOKIE_NAME = 'VKONTAKTE_USER_TOKEN';
    const EXTRA_COOKIE_NAME = 'VKONTAKTE_USER_EXTRA_TOKEN';

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

    public static function hasToken()
    {
        return Cookie::has(self::COOKIE_NAME);
    }

    public static function setExtraToken(string $token, int $expires = 43200)
    {
        Cookie::queue(self::EXTRA_COOKIE_NAME, $token, $expires);
    }

    public static function removeExtraToken()
    {
        Cookie::queue(self::EXTRA_COOKIE_NAME, '', -1);
    }

    public static function getExtraToken()
    {
        return Cookie::get(self::EXTRA_COOKIE_NAME, '');
    }

    public static function hasExtraToken()
    {
        return Cookie::has(self::EXTRA_COOKIE_NAME);
    }
}
