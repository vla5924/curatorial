<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\Practice;
use App\Models\PracticePicture;
use App\Models\PublishedPracticePicture;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Support\Facades\Auth;

class PracticePublishService extends VkApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->requireExtraToken();
    }

    protected function uploadWallPhoto(PracticePicture $picture, string $uploadUrl)
    {
        $fullPath = storage_path('app') . '/' . $picture->path;
        $parameters = ['photo' => new \CURLFile($fullPath)];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true) ?? [];
    }

    public function publish(
        Practice $practice,
        Group $group,
        string $message,
        int $publishDate,
        int $interval,
        bool $signed
    ) {
        try {
            $this->checkExtraToken();
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }

        $response = $this->callForResponse('photos.getWallUploadServer', [
            'group_id' => $group->vk_id,
        ]);
        $uploadUrl = $response['upload_url'];
        $ok = true;
        $results = [];
        $i = 0;
        foreach ($practice->pictures as $picture) {
            $uploadInfo = $this->uploadWallPhoto($picture, $uploadUrl);

            try {
                $response = $this->callForResponse('photos.saveWallPhoto', [
                    'group_id' => $group->vk_id,
                    'photo' => $uploadInfo['photo'],
                    'server' => $uploadInfo['server'],
                    'hash' => $uploadInfo['hash'],
                ]);
            } catch (VkException $e) {
                $results[] = [
                    'ok' => false,
                    'error' => $e->getMessage(),
                ];
                $ok = false;
                continue;
            }

            $ownerId = $response[0]['owner_id'];
            $attachments = 'photo' . $ownerId . '_' . $response[0]['id'];

            try {
                $response = $this->callExtraForResponse('wall.post', [
                    'owner_id'       => -$group->vk_id,
                    'from_group'     => 1,
                    'close_comments' => 0,
                    'signed'         => (int)$signed,
                    'message'        => $message,
                    'attachments'    => $attachments,
                    'publish_date'   => ($publishDate + $interval * 60 * $i++),
                ]);
            } catch (VkException $e) {
                $results[] = [
                    'ok' => false,
                    'error' => $e->getMessage(),
                ];
                $ok = false;
                continue;
            }

            $postId = (-$group->vk_id) . '_' . $response['post_id'];
            try {
                $response = $this->callForResponse('wall.getById', ['posts' => $postId]);
                if (isset($response[0], $response[0]['attachments'])) {
                    $publishedPicture = new PublishedPracticePicture;
                    $publishedPicture->practice_picture_id = $picture->id;
                    $publishedPicture->user_id = Auth::user()->id;
                    $publishedPicture->group_id = $group->id;
                    $publishedPicture->vk_id = (int)$response[0]['attachments'][0]['photo']['id'];
                    $publishedPicture->save();
                }
            } catch (VkException $e) {
            }

            $results[] = [
                'ok' => true,
                'post_id' => $postId,
            ];
        }

        return [
            'ok' => $ok,
            'posts' => $results,
        ];
    }
}
