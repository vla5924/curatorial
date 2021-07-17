<?php

namespace App\Http\Services;

class RepublisherService extends VkApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->requireExtraToken();
    }

    public function publish(array $parameters)
    {
        $this->checkExtraToken();
        return $this->callExtraForResponse('wall.post', $parameters)['post_id'];
    }
}
