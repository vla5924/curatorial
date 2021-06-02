<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function test()
    {
        return ['ok' => true];
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'group_id' => 'required',
            'assign' => 'required',
        ]);

        $user = User::where('id', $request->user_id)->first();
        $group = Group::where('id', $request->group_id)->first();
        $assign = (int)$request->assign;

        if (!$user or !$group) {
            return [
                'ok' => false,
                'error' => 'Invalid request parameters.',
            ];
        }

        if ($assign)
            $user->groups()->attach($group);
        else
            $user->groups()->detach($group);

        return [
            'ok' => true,
            'assign' => $assign,
        ];
    }
}
