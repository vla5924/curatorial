<?php

namespace App\Http\Services;

class BlockerService extends VkApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->requireExtraToken();
    }

    public function ban(int $userId, int $groupId)
    {
        $this->callExtra('groups.ban', [
            'owner_id' => $userId,
            'group_id' => $groupId,
            'reason' => 1,
            'comment' => 'Automated service (Curatorial Blocker)',
        ]);
    }

    public function unban(int $userId, int $groupId)
    {
        $this->callExtra('groups.unban', [
            'owner_id' => $userId,
            'group_id' => $groupId,
        ]);
    }
}
