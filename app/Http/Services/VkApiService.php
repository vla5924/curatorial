<?php

use \ATehnix\VkClient\Client as VkClient;

class VkApiService
{
    const API_VERSION = '5.100';

    protected $token;
    protected $api;

    public function __construct(string $token)
    {
        $this->token = $token;

        $this->api = new VkClient(static::API_VERSION);
        $this->api->setDefaultToken($this->token);
    }
}
