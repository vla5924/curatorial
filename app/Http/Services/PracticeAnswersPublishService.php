<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\PostAttachment;
use App\Models\Practice;
use App\Models\PracticePicture;
use App\Models\PublishedPracticePicture;
use ATehnix\VkClient\Exceptions\VkException;

class PracticeAnswersPublishService extends VkApiService
{
    const TEXT_ANSWER_FORMATTED = 'ПРАВИЛЬНЫЙ ОТВЕТ: %s';

    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException(__(self::EXTRA_TOKEN_IS_NOT_FOUND));
        parent::__construct(VkTokenService::getExtraToken());
    }

    public function publish(Practice $practice)
    {
        /*try {
            $this->checkToken();
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }*/

        $ok = true;
        $results = [];
        $i = 0;
        foreach ($practice->pictures as $picture) {
            if (!$picture->answer) {
                $results[] = [
                    'ok' => false,
                    'error' => __('practice.picture_has_no_answer'),
                ];
                $ok = false;
                continue;
            }

            $published = PublishedPracticePicture::where('practice_picture_id', $picture->id)->orderBy('created_at', 'desc')->first();
            if (!$published) {
                $results[] = [
                    'ok' => false,
                    'error' => __('practice.picture_has_never_been_published'),
                ];
                $ok = false;
                continue;
            }

            $attachment = PostAttachment::where('vk_owner_id', -$published->group->vk_id)->where('vk_id', $published->vk_id)->orderBy('created_at', 'desc')->first();
            if (!$attachment) {
                $results[] = [
                    'ok' => false,
                    'error' => __('practice.picture_attachment_not_found'),
                ];
                $ok = false;
                continue;
            }

            $post = $attachment->post;
            try {
                $response = $this->api->request('wall.createComment', [
                    'owner_id' => -$post->group->vk_id,
                    'post_id' => $post->vk_id,
                    'from_group' => $post->group->vk_id,
                    'message' => sprintf(self::TEXT_ANSWER_FORMATTED, $picture->answer),
                ])['response'];
            } catch (VkException $e) {
                $results[] = [
                    'ok' => false,
                    'error' => $e->getMessage(),
                ];
                $ok = false;
                continue;
            }

            $postId = (-$post->group->vk_id) . '_' . $post->vk_id;
            $results[] = [
                'ok' => true,
                'post_id' => $postId,
                'comment_id' => $response['comment_id'],
            ];
        }

        return [
            'ok' => $ok,
            'posts' => $results,
        ];
    }
}
