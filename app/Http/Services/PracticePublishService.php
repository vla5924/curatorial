<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\Practice;
use App\Models\PracticePicture;
use ATehnix\VkClient\Exceptions\VkException;

class PracticePublishService extends VkApiService
{
    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException(__(self::EXTRA_TOKEN_IS_NOT_FOUND));
        parent::__construct(VkTokenService::getExtraToken());
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
            $this->checkToken();
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }

        $response = $this->api->request('photos.getWallUploadServer', [
            'group_id' => $group->vk_id,
        ], VkTokenService::getToken())['response'];
        $uploadUrl = $response['upload_url'];
        $ok = true;
        $results = [];
        $i = 0;
        foreach ($practice->pictures as $picture) {
            $uploadInfo = $this->uploadWallPhoto($picture, $uploadUrl);

            try {
                $response = $this->api->request('photos.saveWallPhoto', [
                    'group_id' => $group->vk_id,
                    'photo' => $uploadInfo['photo'],
                    'server' => $uploadInfo['server'],
                    'hash' => $uploadInfo['hash'],
                ], VkTokenService::getToken())['response'];
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
                $response = $this->api->request('wall.post', [
                    'owner_id'       => -$group->vk_id,
                    'from_group'     => 1,
                    'close_comments' => 0,
                    'signed'         => (int)$signed,
                    'message'        => $message,
                    'attachments'    => $attachments,
                    'publish_date'   => ($publishDate + $interval * 60 * $i++),
                ])['response'];
            } catch (VkException $e) {
                $results[] = [
                    'ok' => false,
                    'error' => $e->getMessage(),
                ];
                $ok = false;
                continue;
            }

            $results[] = [
                'ok' => true,
                'post_id' => (-$group->vk_id) . '_' . $response['post_id'],
            ];
        }

        return [
            'ok' => $ok,
            'posts' => $results,
        ];
    }
}
