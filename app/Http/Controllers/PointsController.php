<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    public function nullify()
    {
        $users = User::orderBy('name')->paginate(20);
        $lastNullifications = $users->mapWithKeys(function ($user, $key) {
            $lastNullification = $user->pointsNullifications()->orderBy('created_at', 'desc')->first();
            return [$user->id => $lastNullification];
        });

        return view('pages.admin.points.nullify', [
            'users' => $users,
            'last_nullifications' => $lastNullifications,
        ]);
    }

    public function adjust()
    {
    }
}
