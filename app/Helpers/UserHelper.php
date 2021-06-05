<?php

namespace App\Helpers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;

class UserHelper
{
    public static function ordered()
    {
        return User::orderBy('name');
    }

    public static function active()
    {
        return User::role(['user', 'admin']);
    }

    public static function activeOrdered()
    {
        return self::active()->orderBy('name');
    }

    public static function points(User $user, ?Group $group = null)
    {
        $postsQuery = Post::where('signer_id', $user->id);
        if ($group)
            $postsQuery = $postsQuery->where('group_id', $group->id);
        $lastNullification = $user->pointsNullifications()->orderBy('created_at', 'desc')->first();
        if ($lastNullification)
            $postsQuery = $postsQuery->where('created_at', '>', $lastNullification->created_at);
        $posts = $postsQuery->get();
        $points = $posts->reduce(function ($total, $post) {
            return $total + $post->points;
        }, 0);
        $points += $user->pointsAdjustments->sum('points');
        return $points;
    }
}
