<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\PracticeAnswersPublishService;
use App\Http\Services\PracticePublishService;
use App\Models\Group;
use App\Models\Practice;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $service = new PracticePublishService;
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

    public function publishAnswers(int $practiceId, Request $request)
    {
        $practice = Practice::where('id', $practiceId)->first();
        if (!$practice)
            return ['ok' => false];

        if ($practice->user->id != Auth::user()->id) {
            return [
                'ok' => false,
                'error' => __('practice.you_are_not_creator')
            ];
        }

        try {
            $service = new PracticeAnswersPublishService;
            return $service->publish($practice);
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
