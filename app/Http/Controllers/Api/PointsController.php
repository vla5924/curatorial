<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PointsAdjustment;
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
            'last_nullification' => date('Y-m-d H:i:s', strtotime($nullification->created_at)),
        ];
    }

    public function adjust(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'group_id' => 'required',
            'points' => 'required',
        ]);

        $user = User::where('id', $request->user_id)->first();
        if (!$user)
            return [
                'ok' => false,
                'error' => 'User not found',
            ];

        $adjustment = PointsAdjustment::where('group_id', $request->group_id)->first();
        if (!$adjustment) {
            $adjustment = new PointsAdjustment;
            $adjustment->user_id = $user->id;
            $adjustment->group_id = $request->group_id;
            $adjustment->pioneer_id = Auth::user()->id;
        }
        $adjustment->points = (int)$request->points;
        $adjustment->save();


        return [
            'ok' => true,
            'points' => $adjustment->points,
        ];
    }
}
