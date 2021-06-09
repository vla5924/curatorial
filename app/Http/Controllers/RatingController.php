<?php

namespace App\Http\Controllers;

use App\Helpers\GroupHelper;
use App\Helpers\UserHelper;
use App\Models\Group;

class RatingController extends Controller
{
    protected static function generateRatingWithView($users, $group = null)
    {
        $groups = GroupHelper::ordered()->get();
        $usersById = $users->mapWithKeys(function ($user, $key) {
            return [$user->id => $user];
        });
        $rating = $users->mapWithKeys(function ($user, $key) use ($group) {
            $points = UserHelper::cachedPoints($user, $group);
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
        $users = UserHelper::active()->get();
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
