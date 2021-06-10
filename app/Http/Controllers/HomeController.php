<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Pollbunch;
use App\Models\Post;
use App\Models\Practice;
use App\Models\UnansweredPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected static function currentSeasonStart()
    {
        $month = (int)date('n');
        if ($month >= 8)
            return mktime(0, 0, 0, 8, 1, (int)date('Y'));
        return mktime(0, 0, 0, 8, 1, date('Y') - 1);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $groups = $user->groups()->orderBy('name')->get();

        $highligts = [
            'points_earned' => UserHelper::cachedPoints($user),
            'posts_unanswered' => UnansweredPost::where('user_id', $user->id)->count(),
        ];

        return view('pages.home.index', [
            'highlights' => $highligts,
            'groups' => $groups,
        ]);
    }
}
