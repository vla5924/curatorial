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
            $posts = Post::where('signer_id', $user->id)->get();
            $points = $posts->reduce(function ($total, $post) {
                return $total + $post->points;
            });
            return [$user->id => $points];
        });
        return view('pages.users.rating', [
            'users' => $usersById,
            'rating' => $rating->sortDesc(),
        ]);
    }
}
