<?php

namespace App\Http\Controllers;

use App\Helpers\GroupHelper;
use App\Helpers\UserHelper;

class PointsController extends Controller
{
    public function nullify()
    {
        $users = UserHelper::activeOrdered()->paginate(20);

        return view('pages.admin.points.nullify', [
            'users' => $users,
        ]);
    }

    public function adjust()
    {
        $users = UserHelper::activeOrdered()->paginate(20);
        $groups = GroupHelper::ordered()->get();

        return view('pages.admin.points.adjust', [
            'users' => $users,
            'groups' => $groups,
        ]);
    }
}
