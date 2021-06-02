<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::where('id', $request->user_id)->first();
        $role = Role::where('id', $request->role_id)->first();

        if (!$user or !$role) {
            return [
                'ok' => false,
                'error' => 'Invalid request parameters.',
            ];
        }

        foreach ($user->roles as $r)
            $user->removeRole($r->name);
        $user->assignRole($role->name);

        return ['ok' => true];
    }
}
