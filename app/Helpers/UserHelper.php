<?php

namespace App\Helpers;

use App\Models\CachedPoints;
use App\Models\Group;
use App\Models\PointsAdjustment;
use App\Models\PointsNullification;
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
        if ($group) {
            $adjustment = self::pointsAdjustment($user, $group);
            if ($adjustment)
                $points += $adjustment->points;
        } else {
            $points += $user->pointsAdjustments->sum('points');
        }
        return $points;
    }

    public static function pointsAdjustment(User $user, Group $group)
    {
        return PointsAdjustment::where('user_id', $user->id)->where('group_id', $group->id)->first();
    }

    public static function lastPointsNullification(User $user)
    {
        return PointsNullification::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
    }

    public static function cachePoints(User $user, ?Group $group = null, int $points = 0)
    {
        $cached = CachedPoints::where('user_id', $user->id)->where('group_id', $group ? $group->id : null);
        if (!$cached) {
            $cached = new CachedPoints;
            $cached->user_id = $user->id;
            $cached->group_id = $group->id;
        }
        $cached->points = $points;
        $cached->save();
    }

    public static function cachedPoints(User $user, ?Group $group = null)
    {
        $cached = CachedPoints::where('user_id', $user->id)->where('group_id', $group ? $group->id : null);
        if ($cached)
            return $cached->points;

        $points = self::points($user, $group);
        self::cachePoints($user, $group, $points);
        return $points;
    }
}
