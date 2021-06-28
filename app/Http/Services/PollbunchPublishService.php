<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\Pollbunch;
use App\Models\PollbunchQuestion;
use App\Models\PublishedPollbunchQuestion;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Support\Facades\Auth;

class PollbunchPublishService extends VkApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->requireExtraToken();
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
        return $this->callExtraForResponse('polls.create', $parameters);
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
            $this->checkExtraToken();
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
                    'error' => __('pollbunches.cannot_create_poll') . ' ' . $e->getMessage(),
                ];
                $ok = false;
                continue;
            }

            $ownerId = -$group->vk_id;
            $pollId = $response['owner_id'] . '_' . $response['id'];
            $attachments = 'poll' . $pollId;

            $publishedQuestion = new PublishedPollbunchQuestion;
            $publishedQuestion->pollbunch_question_id = $question->id;
            $publishedQuestion->user_id = Auth::user()->id;
            $publishedQuestion->group_id = $group->id;
            $publishedQuestion->vk_id = (int)$response['id'];
            $publishedQuestion->save();

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
                $response = $this->callExtraForResponse('wall.post', $parameters);
            } catch (VkException $e) {
                $posts[] = [
                    'ok' => false,
                    'error' => __('pollbunches.cannot_create_post') . ' ' . $e->getMessage(),
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
