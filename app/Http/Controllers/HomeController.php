<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Pollbunch;
use App\Models\Post;
use App\Models\Practice;
use Illuminate\Http\Request;

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
        $highligts = [
            'active_users' => UserHelper::active()->count(),
            'posts_published' => Post::where('created_at', '>=', date('Y-m-d H:i:s', self::currentSeasonStart()))->count(),
            'practices_created' => Practice::count(),
            'pollbunches_created' => Pollbunch::count(),
        ];

        return view('pages.home.index', [
            'highlights' => $highligts,
        ]);
    }
}
