<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function assign()
    {
        $users = User::orderBy('name')->paginate(20);
        $roles = Role::orderBy('name')->get();

        return view('pages.admin.roles.assign', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
