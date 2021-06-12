<?php

namespace App\Http\Controllers;

use App\Http\Services\VkApiService;
use App\Http\Services\VkTokenService;
use Illuminate\Http\Request;

class ExtraTokenController extends Controller
{
    protected static function generateView()
    {
        $hasToken = VkTokenService::hasExtraToken();
        $urlParameters = [
            'client_id' => config('services.vkontakte_extra.client_id'),
            'display' => 'page',
            'redirect_uri' => 'https://oauth.vk.com/blank.html',
            'scope' => 'offline,wall,groups',
            'response_type' => 'token',
            'v' => VkApiService::API_VERSION,
        ];
        $url = 'https://oauth.vk.com/authorize?' . http_build_query($urlParameters);

        return view('pages.settings.extra-token', [
            'has_token' => $hasToken,
            'extra_token_link' => $url,
        ]);
    }

    public function index()
    {
        return self::generateView();
    }

    public function store(Request $request)
    {
        $request->validate([
            'extra_token' => 'required',
        ]);

        $token = $request->extra_token;
        VkTokenService::setExtraToken($token);

        return self::generateView();
    }
}
