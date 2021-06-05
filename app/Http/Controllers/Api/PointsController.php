<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PointsNullification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointsController extends Controller
{
    public function nullify(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $user = User::where('id', $request->user_id)->first();
        if (!$user)
            return [
                'ok' => false,
                'error' => 'User not found',
            ];

        $nullification = new PointsNullification;
        $nullification->user_id = $user->id;
        $nullification->pioneer_id = Auth::user()->id;
        $nullification->save();

        return [
            'ok' => true,
            'last_nullification' => $nullification->created_at,
        ];
    }
}
