<?php

namespace App\Http\Services;

use ATehnix\VkClient\Client as VkClient;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Support\Facades\Auth;

class VkApiService
{
    const API_VERSION = '5.130';

    const TOKEN_IS_INVALID = 'Token is invalid: no response while checking, please reauthorize';
    const TOKEN_IS_UNFAMILIAR = 'Token does not belongs to current user, please reauthorize';
    const EXTRA_TOKEN_IS_NOT_FOUND = 'Extra token is not found, please add it in settings';

    protected $token;
    protected $api;

    public function __construct(string $token)
    {
        $this->token = $token;

        $this->api = new VkClient(static::API_VERSION);
        $this->api->setDefaultToken($this->token);
    }

    public function checkToken()
    {
        $response = $this->api->request('users.get', [])['response'];
        if (empty($response))
            throw new VkException(self::TOKEN_IS_INVALID);
        if ($response[0]['id'] != Auth::user()->vk_id)
            throw new VkException(self::TOKEN_IS_UNFAMILIAR);
    }
}
