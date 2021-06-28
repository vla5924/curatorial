<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use ATehnix\VkClient\Exceptions\VkException;

class UserService extends VkApiService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGroups()
    {
        return $this->callForResponse('groups.get', [
            'filter' => 'admin,editor',
            'extended' => 1,
        ])['items'];
    }
}
