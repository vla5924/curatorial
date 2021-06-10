<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use ATehnix\VkClient\Exceptions\VkException;

class UserService extends VkApiService
{
    public function __construct()
    {
        parent::__construct(VkTokenService::getToken());
    }

    public function getGroups()
    {
        return $this->api->request('groups.get', [
            'filter' => 'admin,editor',
            'extended' => 1,
        ])['response']['items'];
    }
}
