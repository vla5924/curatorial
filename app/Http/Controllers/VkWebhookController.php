<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\User;
use Illuminate\Http\Request;

class VkWebhookController extends Controller
{
    const SECRET_KEY = 'icur27801';
    const SUCCESS_TEXT = 'ok';
    const FALLBACK_TEXT = 'error';

    const ATTACHMENT_TYPES = ['photo', 'video', 'audio', 'poll', 'doc', 'link'];

    public static function cleanUpText(string $text): string
    {
        return preg_replace('/[^a-zA-ZА-Яа-я0-9_\.#\s]/', '', $text);
    }

    public function index(Request $request)
    {
        if ($request->secret != self::SECRET_KEY)
            return self::FALLBACK_TEXT;

        if ($request->type == 'confirmation') {
            $group = Group::where('vk_id', $request->group_id)->first();
            if (!$group)
                return self::FALLBACK_TEXT;
            return $group->vk_confirmation_token;
        }

        if ($request->type == 'wall_post_new') {
            $postData = $request->object;

            if ($postData->marked_as_ads || $postData->post_type != 'post')
                return self::SUCCESS_TEXT;

            $post = new Post;

            $group = Group::where('vk_id', -$postData->owner_id)->first();
            if (!$group)
                return self::FALLBACK_TEXT;
            $post->group_id = $group->id;

            $creator = User::where('vk_id', $postData->created_by)->first();
            $signer = User::where('vk_id', $postData->signer_id)->first();
            $post->created_by = $creator ? $creator->id : null;
            $post->signed_by = $signer ? $signer->id : null;

            $post->text = self::cleanUpText($postData->text);
            $post->vk_id = $postData->id;
            $post->save();

            if (!$postData->attachments)
                return self::SUCCESS_TEXT;

            foreach ($postData->attachments as $attachmentData) {
                $type = $attachmentData->type;
                if (!\in_array($type, self::ATTACHMENT_TYPES))
                    continue;

                $attachment = new PostAttachment;
                $attachment->post_id = $post->id;

                if ($type == 'photo') {
                    if ($attachmentData->photo->owner_id != $postData->owner_id)
                        continue;

                    $sizes = [];
                    foreach ($attachmentData->photo->sizes as $size)
                        $sizes[$size->type] = $size->url;
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
                    $attachment->vk_id = $attachmentData->photo->id;
                    $attachment->meta = [
                        'lg' => $sizes[$sbig],
                        'sm' => $sizes[$ssmall],
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'video') {
                    if ($attachmentData->video->owner_id != $postData->owner_id)
                        continue;

                    $attachment->type = 'video';
                    $attachment->vk_id = $attachmentData->video->id;
                    $attachment->meta = [
                        'thumb' => $attachmentData->video->photo_320,
                        'duration' => $attachmentData->video->duration,
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'audio') {
                    $attachment->type = 'audio';
                    $attachment->vk_id = $attachmentData->audio->id;
                    $attachment->meta = [
                        'owner_id' => $attachmentData->audio->owner_id,
                        'artist' => $attachmentData->audio->artist,
                        'title' => $attachmentData->audio->title,
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'poll') {
                    if ($attachmentData->poll->owner_id != $postData->owner_id)
                        continue;

                    $attachment->type = 'poll';
                    $attachment->vk_id = $attachmentData->poll->id;
                    $attachment->meta = [
                        'artist' => $attachmentData->audio->artist,
                        'title' => $attachmentData->audio->title,
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'doc') {
                    $attachment->type = 'doc';
                    $attachment->vk_id = $attachmentData->doc->id;
                    $attachment->meta = [
                        'owner_id' => $attachmentData->doc->owner_id,
                        'title' => $attachmentData->doc->title,
                        'size' => $attachmentData->doc->size,
                        'type' => $attachmentData->doc->type,
                        'url' => $attachmentData->doc->url,
                    ];
                    $attachment->save();
                    continue;
                }

                if ($type == 'link') {
                    $attachment->type = 'link';
                    $attachment->vk_id = null;
                    $attachment->meta = [
                        'title' => $attachmentData->link->title,
                        'url' => $attachmentData->link->url,
                    ];
                    $attachment->save();
                    continue;
                }
            }
        }

        return self::FALLBACK_TEXT;
    }
}
