<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\RepublisherService;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;

class RepublisherController extends Controller
{
    public function publish(Request $request)
    {
        $request->validate([
            'owner_id' => 'required',
            'publish_date' => 'required',
            'signed' => 'required',
            'message' => 'required',
            'attachments' => 'required',
        ]);

        try {
            $service = new RepublisherService;
            $parameters = [
                'owner_id' => $request->owner_id,
                'from_group' => 1,
                'publish_date' => strtotime($request->publish_date),
                'signed' => (int)$request->signed,
                'message' => $request->message,
                'attachments' => $request->attachments,
                'close_comments' => 0,
            ];
            return [
                'ok' => true,
                'post_id' => $service->publish($parameters),
            ];
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
