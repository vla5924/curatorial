<?php

namespace App\Http\Controllers;

use App\Http\Services\VkTokenService;
use Illuminate\Http\Request;

class ExtraTokenController extends Controller
{
    public function index()
    {
        $hasToken = VkTokenService::hasExtraToken();

        return view('pages.settings.extra-token', [
            'has_token' => $hasToken,
        ]);
    }

    public function store(Request $request)
    {
        $token = $request->extra_token;
        VkTokenService::setExtraToken($token);

        return view('pages.settings.extra-token', [
            'has_token' => true,
        ]);
    }
}
