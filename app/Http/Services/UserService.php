<?php

namespace App\Http\Services;

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
