<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use ATehnix\VkClient\Exceptions\VkException;

class RepublisherService extends VkApiService
{
    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException(__(self::EXTRA_TOKEN_IS_NOT_FOUND));
        parent::__construct(VkTokenService::getExtraToken());
    }

    public function publish(array $parameters)
    {
        $this->checkToken();
        return $this->api->request('wall.post', $parameters)['response']['post_id'];
    }
}
