<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\UnansweredPost;
use App\Models\User;
use Illuminate\Http\Request;

class VkWebhookController extends Controller
{
    const RETURN_TEXT = 'ok';

    const ATTACHMENT_TYPES = ['photo', 'video', 'audio', 'poll', 'doc', 'link'];

    const ANSWER_TEXT_MARKERS = ['answer', 'ответ'];


    protected static function cleanUpText(string $text): string
    {
        // This is a temporary workaround for not to break russian symbols
        return $text;

        // This regular expression should be fixed to fully support russian symbols
        // return preg_replace('/[^a-zA-ZА-Яа-я0-9_\.#:\/!,\(\)\s]/', '', $text);
    }

    protected static function isPracticeText(string $text): bool
    {
        return (bool)preg_match('/#[a-z]+_p/', $text);
    }

    protected static function isAnswerText(string $text): bool
    {
        foreach (self::ANSWER_TEXT_MARKERS as $marker)
            if (mb_stripos($text, $marker) !== false)
                return true;
        return false;
    }

    public function index(Request $request)
    {
        if (!$request->has(['type', 'secret']) or $request->secret != config('services.vkontakte_webhook.secret'))
            return self::RETURN_TEXT;

        if ($request->type == 'confirmation') {
            $group = Group::where('vk_id', $request->group_id)->first();
            if (!$group)
                return self::RETURN_TEXT;
            return $group->vk_confirmation_token;
        }

        if ($request->type == 'wall_post_new') {
            if (!$request->has('object'))
                return self::RETURN_TEXT;

            $postData = $request->object;

            if ($postData['marked_as_ads'] || $postData['post_type'] != 'post')
                return self::RETURN_TEXT;

            $post = new Post;

            $group = Group::where('vk_id', -$postData['owner_id'])->first();
            if (!$group)
                return self::RETURN_TEXT;
            $post->group_id = $group->id;

            $creator = User::where('vk_id', $postData['created_by'])->first();
            $signer = isset($postData['signer_id']) ? User::where('vk_id', $postData['signer_id'])->first() : null;
            $post->creator_id = $creator ? $creator->id : null;
            $post->signer_id = $signer ? $signer->id : null;

            $post->text = self::cleanUpText($postData['text']);
            $post->vk_id = $postData['id'];
            $post->save();

            if (self::isPracticeText($post->text)) {
                $unansweredPost = new UnansweredPost;
                $unansweredPost->post_id = $post->id;
                $unansweredPost->user_id = $post->signer_id;
                $unansweredPost->save();
            }

            if (!isset($postData['attachments']))
                return self::RETURN_TEXT;

            foreach ($postData['attachments'] as $attachmentData) {
                $type = $attachmentData['type'];
                if (!\in_array($type, self::ATTACHMENT_TYPES))
                    continue;

                $attachment = new PostAttachment;
                $attachment->post_id = $post->id;

                if ($type == 'photo') {
                    $sizes = [];
                    foreach ($attachmentData['photo']['sizes'] as $size)
                        $sizes[$size['type']] = $size['url'];
                    if (isset($sizes["w"])) $sbig = "w";
                    elseif (isset($sizes["z"])) $sbig = "z";
                    elseif (isset($sizes["y"])) $sbig = "y";
                    elseif (isset($sizes["x"])) $sbig = "x";
                    elseif (isset($sizes["r"])) $sbig = "r";
                    if (isset($sizes["p"])) $ssmall = "p";
                    elseif (isset($sizes["m"])) $ssmall = "m";
                    elseif (isset($sizes["o"])) $ssmall = "o";
                    elseif (isset($sizes["s"])) $ssmall = "s";

                    $attachment->type = 'photo';
                    $attachment->vk_owner_id = $attachmentData['photo']['owner_id'];
                    $attachment->vk_id = $attachmentData['photo']['id'];
                    $attachment->meta = [
                        'lg' => $sizes[$sbig],
                        'sm' => $sizes[$ssmall],
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'video') {
                    $attachment->type = 'video';
                    $attachment->vk_owner_id = $attachmentData['video']['owner_id'];
                    $attachment->vk_id = $attachmentData['video']['id'];
                    if (isset($attachmentData['video']['image'][2]))
                        $thumb = $attachmentData['video']['image'][2]['url'];
                    else
                        $thumb = $attachmentData['video']['image'][0]['url'];
                    $attachment->meta = [
                        'thumb' => $thumb,
                        'duration' => $attachmentData['video']['duration'],
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'audio') {
                    $attachment->type = 'audio';
                    $attachment->vk_owner_id = $attachmentData['audio']['owner_id'];
                    $attachment->vk_id = $attachmentData['audio']['id'];
                    $attachment->meta = [
                        'artist' => $attachmentData['audio']['artist'],
                        'title' => $attachmentData['audio']['title'],
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'poll') {
                    $attachment->type = 'poll';
                    $attachment->vk_owner_id = $attachmentData['poll']['owner_id'];
                    $attachment->vk_id = $attachmentData['poll']['id'];
                    $attachment->meta = [
                        'question' => $attachmentData['poll']['question'],
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'doc') {
                    $attachment->type = 'doc';
                    $attachment->vk_owner_id = $attachmentData['doc']['owner_id'];
                    $attachment->vk_id = $attachmentData['doc']['id'];
                    $attachment->meta = [
                        'title' => $attachmentData['doc']['title'],
                        'size' => $attachmentData['doc']['size'],
                        'type' => $attachmentData['doc']['type'],
                        'url' => $attachmentData['doc']['url'],
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'link') {
                    $attachment->type = 'link';
                    $attachment->vk_owner_id = null;
                    $attachment->vk_id = null;
                    $attachment->meta = [
                        'title' => $attachmentData['link']['title'],
                        'url' => $attachmentData['link']['url'],
                    ];
                    $attachment->save();
                    continue;
                }
            }

            return self::RETURN_TEXT;
        }

        if ($request->type == 'wall_reply_new') {
            if (!$request->has('object'))
                return self::RETURN_TEXT;

            $commentData = $request->object;

            if ($commentData['post_owner_id'] != $commentData['from_id'])
                return self::RETURN_TEXT;

            $postOwnerId = (int)$commentData['post_owner_id'];
            if ($postOwnerId >= 0)
                return self::RETURN_TEXT;

            if (!self::isAnswerText($commentData['text']))
                return self::RETURN_TEXT;

            $group = Group::where('vk_id', -$postOwnerId)->first();
            if (!$group)
                return self::RETURN_TEXT;

            $post = Post::where('group_id', $group->id)->where('vk_id', $commentData['post_id'])->first();
            if (!$post)
                return self::RETURN_TEXT;

            $unansweredPost = UnansweredPost::where('post_id', $post->id)->first();
            if (!$unansweredPost)
                return self::RETURN_TEXT;

            $unansweredPost->delete();
            return self::RETURN_TEXT;
        }

        return self::RETURN_TEXT;
    }
}
