<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\Practice;
use ATehnix\VkClient\Exceptions\VkException;

class RepublisherService extends VkApiService
{
    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException('Extra token is not found, please add it in settings');
        parent::__construct(VkTokenService::getExtraToken());
    }

    public function getGroups()
    {
        return $this->api->request('groups.get', [
            'filter' => 'admin,editor,moder',
            'extended' => 1,
        ], VkTokenService::getToken())['response']['items'];
    }

    public function publish(array $parameters)
    {
        $this->checkToken();
        return $this->api->request('wall.post', $parameters)['response']['post_id'];
    }
}
