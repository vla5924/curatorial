<?php

namespace App\Http\Services;

use App\Models\PostAttachment;
use App\Models\Practice;
use App\Models\PublishedPracticePicture;
use ATehnix\VkClient\Exceptions\VkException;

class PracticeAnswersPublishService extends VkApiService
{
    const TEXT_ANSWER_FORMATTED = 'ПРАВИЛЬНЫЙ ОТВЕТ: %s';

    public function __construct()
    {
        parent::__construct();
        $this->requireExtraToken();
    }

    public function collectAnswers(Practice $practice): array
    {
        $answers = [];
        foreach ($practice->pictures as $picture) {
            if (!$picture->answer)
                continue;
            $answers[$picture->id] = $picture->answer;
        }
        return $answers;
    }

    public function publishAnswers(Practice $practice)
    {
        try {
            $this->checkExtraToken();
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }

        $answers = $this->collectAnswers($practice);
        if (count($answers) != $practice->pictures()->count()) {
            return [
                'ok' => false,
                'error' => __('practice.some_pictures_have_no_answer'),
            ];
        }

        $ok = true;
        $results = [];
        foreach ($practice->pictures as $picture) {
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
                $response = $this->callExtraForResponse('wall.createComment', [
                    'owner_id' => -$post->group->vk_id,
                    'post_id' => $post->vk_id,
                    'from_group' => $post->group->vk_id,
                    'message' => sprintf(self::TEXT_ANSWER_FORMATTED, $answers[$picture->id]),
                ]);
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
