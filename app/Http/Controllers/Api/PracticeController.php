<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\PracticePublishService as PracticePublishService;
use App\Models\Group;
use App\Models\Practice;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function test()
    {
        return ['ok' => true];
    }

    public function publish(int $practiceId, Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'message' => 'required',
            'hashtags' => 'required',
            'publish_date' => 'required',
            'interval' => 'required',
            'signed' => 'required',
        ]);

        $practice = Practice::where('id', $practiceId)->first();
        $group = Group::where('id', $request->group_id)->first();
        $fullMessage = $request->message . PHP_EOL . PHP_EOL . $request->hashtags;

        try {
            $service = new PracticePublishService();
            return $service->publish(
                $practice,
                $group,
                $fullMessage,
                strtotime($request->publish_date),
                (int)$request->interval,
                (bool)$request->signed
            );
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
