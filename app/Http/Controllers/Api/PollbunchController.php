<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\PollbunchAnswersPublishService;
use App\Http\Services\PollbunchPublishService;
use App\Models\Group;
use App\Models\Pollbunch;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollbunchController extends Controller
{
    public function publish(int $pollbunchId, Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'message' => 'required',
            'hashtags' => 'required',
            'publish_date' => 'required',
            'interval' => 'required',
            'signed' => 'required',
        ]);

        $pollbunch = Pollbunch::where('id', $pollbunchId)->first();
        $group = Group::where('id', $request->group_id)->first();
        $fullMessage = $request->message . PHP_EOL . PHP_EOL . $request->hashtags;

        try {
            $service = new PollbunchPublishService;
            return $service->publish(
                $pollbunch,
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

    public function publishAnswers(int $pollbunchId, Request $request)
    {
        $pollbunch = Pollbunch::where('id', $pollbunchId)->first();
        if (!$pollbunch)
            return ['ok' => false];

        if ($pollbunch->user->id != Auth::user()->id) {
            return [
                'ok' => false,
                'error' => __('pollbunches.you_are_not_creator')
            ];
        }

        try {
            $service = new PollbunchAnswersPublishService;
            return $service->publishAnswers($pollbunch);
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
