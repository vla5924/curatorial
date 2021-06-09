<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use ATehnix\VkClient\Exceptions\VkException;

class BlockerService extends VkApiService
{
    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException(__(self::EXTRA_TOKEN_IS_NOT_FOUND));
        parent::__construct(VkTokenService::getExtraToken());
    }

    public function ban(int $userId, int $groupId)
    {
        $this->api->request('groups.ban', [
            'owner_id' => $userId,
            'group_id' => $groupId,
            'reason' => 1,
            'comment' => 'Automated service (Curatorial Blocker)',
        ]);
    }

    public function unban(int $userId, int $groupId)
    {
        $this->api->request('groups.unban', [
            'owner_id' => $userId,
            'group_id' => $groupId,
        ]);
    }
}
