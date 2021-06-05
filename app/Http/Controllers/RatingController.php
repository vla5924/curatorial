<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $users = User::all();
        $usersById = $users->mapWithKeys(function ($user, $key) {
            return [$user->id => $user];
        });
        $rating = $users->mapWithKeys(function ($user, $key) {
            $postsQuery = Post::where('signer_id', $user->id);
            $lastNullification = $user->pointsNullifications()->orderBy('created_at', 'desc')->first();
            if ($lastNullification)
                $postsQuery = $postsQuery->where(['created_at', '>', $lastNullification->created_at]);
            $posts = $postsQuery->get();
            $points = $posts->reduce(function ($total, $post) {
                return $total + $post->points;
            }, 0);
            return [$user->id => $points];
        });
        return view('pages.users.rating', [
            'users' => $usersById,
            'rating' => $rating->sortDesc(),
        ]);
    }
}
