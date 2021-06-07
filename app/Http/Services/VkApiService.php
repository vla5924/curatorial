<?php

namespace App\Http\Services;

use ATehnix\VkClient\Client as VkClient;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Support\Facades\Auth;

class VkApiService
{
    const API_VERSION = '5.130';

    const TOKEN_IS_INVALID = 'misc.token_is_invalid';
    const TOKEN_IS_UNFAMILIAR = 'misc.token_is_unfamiliar';
    const EXTRA_TOKEN_IS_NOT_FOUND = 'misc.extra_token_not_foundF';

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
            throw new VkException(__(self::TOKEN_IS_INVALID));
        if ($response[0]['id'] != Auth::user()->vk_id)
            throw new VkException(__(self::TOKEN_IS_UNFAMILIAR));
    }
}
