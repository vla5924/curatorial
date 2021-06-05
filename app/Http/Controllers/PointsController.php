<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    public function nullify()
    {
        $users = User::orderBy('name')->paginate(20);

        return view('pages.admin.points.nullify', [
            'users' => $users,
        ]);
    }

    public function adjust()
    {
        $users = User::orderBy('name')->paginate(20);
        $groups = Group::orderBy('name')->get();

        return view('pages.admin.points.adjust', [
            'users' => $users,
            'groups' => $groups,
        ]);
    }
}
