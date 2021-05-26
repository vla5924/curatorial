<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\Pollbunch;
use App\Models\PollbunchQuestion;
use ATehnix\VkClient\Exceptions\VkException;

class PollbunchPublishService extends VkApiService
{
    public function __construct()
    {
        if (!VkTokenService::hasExtraToken())
            throw new VkException('Extra token is not found, please add it in settings');
        parent::__construct(VkTokenService::getExtraToken());
    }

    protected function createPoll(PollbunchQuestion $question, Group $group)
    {
        $answers = [];
        foreach ($question->answers as $answer)
            $answers[] = $answer->text;
        $parameters = [
            'question' => $question->text,
            'is_anonymous' => 0,
            'is_multiple' => (int)$question->multiple,
            'owner_id' => -$group->vk_id,
            'add_answers' => json_encode($answers),
        ];
        return $this->api->request('polls.create', $parameters)['response'];
    }

    public function publish(
        Pollbunch $pollbunch,
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

        $ok = true;
        $posts = [];
        $i = 0;
        foreach ($pollbunch->questions as $question) {
            try {
                $response = $this->createPoll($question, $group);
            } catch (VkException $e) {
                $posts[] = [
                    'ok' => false,
                    'error' => 'Cannot create poll. ' . $e->getMessage(),
                ];
                $ok = false;
                continue;
            }

            $ownerId = -$group->vk_id;
            $pollId = $response['owner_id'] . '_' . $response['id'];
            $attachments = 'poll' . $pollId;

            $question->vk_poll_id = $pollId;
            $question->save();

            try {
                $parameters = [
                    'owner_id'       => $ownerId,
                    'from_group'     => 1,
                    'close_comments' => 0,
                    'signed'         => (int)$signed,
                    'message'        => $message,
                    'attachments'    => $attachments,
                    'publish_date'   => ($publishDate + $interval * 60 * $i++),
                ];
                $response = $this->api->request('wall.post', $parameters)['response'];
            } catch (VkException $e) {
                $posts[] = [
                    'ok' => false,
                    'error' => 'Cannot create post. ' . $e->getMessage() . json_encode($parameters, JSON_UNESCAPED_UNICODE),
                ];
                $ok = false;
                continue;
            }

            $posts[] = [
                'ok' => true,
                'post_id' => $ownerId . '_' . $response['post_id'],
            ];
        }

        return [
            'ok' => $ok,
            'posts' => $posts,
        ];
    }
}
