<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected static function countPoints(User $user, ?Group $group = null)
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

    protected static function generateRatingWithView($users, $group = null)
    {
        $groups = Group::orderBy('name')->get();
        $usersById = $users->mapWithKeys(function ($user, $key) {
            return [$user->id => $user];
        });
        $rating = $users->mapWithKeys(function ($user, $key) use ($group) {
            $points = self::countPoints($user, $group);
            return [$user->id => $points];
        });

        return view('pages.users.rating', [
            'groups' => $groups,
            'group' => $group,
            'users' => $usersById,
            'rating' => $rating->sortDesc(),
        ]);
    }

    public function index()
    {
        $users = User::all();
        return self::generateRatingWithView($users);
    }

    public function group(int $groupId)
    {
        $group = Group::where('id', $groupId)->first();
        if (!$group)
            abort(404);
        return self::generateRatingWithView($group->users, $group);
    }
}
