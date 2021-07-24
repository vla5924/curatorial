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
    const EXTRA_TOKEN_IS_NOT_FOUND = 'misc.extra_token_not_found';

    protected $token;
    protected $extraToken;
    protected $api;

    protected $limitRequestsPerSec = 3;
    private $prevMicrotime = 0;
    private $requestsExecuted = 0;

    protected function __construct()
    {
        $this->token = VkTokenService::getToken();

        $this->api = new VkClient(static::API_VERSION);
        $this->api->setDefaultToken($this->token);
    }

    protected function requireExtraToken()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException(__(self::EXTRA_TOKEN_IS_NOT_FOUND));

        $this->extraToken = VkTokenService::getExtraToken();
    }

    private function preventFlood()
    {
        $currMicrotime = microtime(true);
        $elapsed = $currMicrotime - $this->prevMicrotime;
        if ($elapsed <= 1 && $this->requestsExecuted >= $this->limitRequestsPerSec) {
            $wait = 1.01 - $elapsed;
            usleep((int)($wait * 1e6));
            $this->requestsExecuted = 1;
            $this->prevMicrotime = microtime(true);
        } else {
            if ($elapsed > 1)
                $this->prevMicrotime = $currMicrotime;
            $this->requestsExecuted++;
        }
    }

    protected function call(string $method, $parameters = [])
    {
        $this->preventFlood();
        return $this->api->request($method, $parameters);
    }

    protected function callForResponse(string $method, $parameters = [])
    {
        return $this->call($method, $parameters)['response'];
    }

    protected function callExtra(string $method, $parameters = [])
    {
        $this->preventFlood();
        return $this->api->request($method, $parameters, $this->extraToken);
    }

    protected function callExtraForResponse(string $method, $parameters = [])
    {
        return $this->callExtra($method, $parameters)['response'];
    }

    private function checkTokenResponse($response)
    {
        if (empty($response))
            throw new VkException(__(self::TOKEN_IS_INVALID));
        if ($response[0]['id'] != Auth::user()->vk_id)
            throw new VkException(__(self::TOKEN_IS_UNFAMILIAR));
    }

    protected function checkToken()
    {
        $this->checkTokenResponse($this->callForResponse('users.get'));
    }

    protected function checkExtraToken()
    {
        $this->checkTokenResponse($this->callExtraForResponse('users.get'));
    }
}
