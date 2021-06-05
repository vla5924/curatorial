<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function assign()
    {
        $users = UserHelper::ordered()->paginate(20);
        $roles = Role::orderBy('name')->get();

        return view('pages.admin.roles.assign', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
