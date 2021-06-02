<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\BlockerService;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;

class BlockerController extends Controller
{
    public function ban(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'group_id' => 'required',
        ]);

        try {
            $service = new BlockerService;
            $service->ban($request->user_id, $request->group_id);
            return ['ok' => true];
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function unban(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'group_id' => 'required',
        ]);

        try {
            $service = new BlockerService;
            $service->unban($request->user_id, $request->group_id);
            return ['ok' => true];
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
