<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Pollbunch;
use App\Models\PostAttachment;
use App\Models\PublishedPollbunchQuestion;
use ATehnix\VkClient\Exceptions\VkException;

class PollbunchAnswersPublishService extends VkApiService
{
    const TEXT_ANSWER_FORMATTED = 'ПРАВИЛЬНЫЙ ОТВЕТ: %s';

    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException(__(self::EXTRA_TOKEN_IS_NOT_FOUND));
        parent::__construct(VkTokenService::getExtraToken());
    }

    public function collectAnswers(Pollbunch $pollbunch): array
    {
        $allAnswers = [];
        foreach ($pollbunch->questions as $question) {
            $answers = $question->answers()->where('correct', true)->get();
            if (!$answers or $answers->isEmpty())
                continue;
            $answers->transform(function ($answer, $key) {
                return $answer->text;
            });
            $allAnswers[$question->id] = $answers->all();
        }
        return $allAnswers;
    }

    public function publishAnswers(Pollbunch $pollbunch)
    {
        try {
            $this->checkToken();
        } catch (VkException $e) {
            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
        }

        $answers = $this->collectAnswers($pollbunch);
        if (count($answers) != $pollbunch->questions()->count()) {
            return [
                'ok' => false,
                'error' => __('pollbunches.some_questions_have_no_answers'),
            ];
        }

        $ok = true;
        $results = [];
        foreach ($pollbunch->questions as $question) {
            $published = PublishedPollbunchQuestion::where('pollbunch_question_id', $question->id)->orderBy('created_at', 'desc')->first();
            if (!$published) {
                $results[] = [
                    'ok' => false,
                    'error' => __('pollbunches.question_has_never_been_published'),
                ];
                $ok = false;
                continue;
            }

            $attachment = PostAttachment::where('vk_owner_id', -$published->group->vk_id)->where('vk_id', $published->vk_id)->orderBy('created_at', 'desc')->first();
            if (!$attachment) {
                $results[] = [
                    'ok' => false,
                    'error' => __('pollbunches.poll_not_found'),
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
                    'message' => sprintf(self::TEXT_ANSWER_FORMATTED, implode(', ', $answers[$question->id])),
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
