<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view profiles']);
        Permission::create(['name' => 'view rating']);

        Permission::create(['name' => 'view groups']);
        Permission::create(['name' => 'create groups']);
        Permission::create(['name' => 'edit groups']);
        Permission::create(['name' => 'delete groups']);
        Permission::create(['name' => 'assign groups']);

        Permission::create(['name' => 'view practices']);
        Permission::create(['name' => 'create practices']);
        Permission::create(['name' => 'edit practices']);
        Permission::create(['name' => 'delete practices']);
        Permission::create(['name' => 'publish practices']);

        Permission::create(['name' => 'view pollbunches']);
        Permission::create(['name' => 'create pollbunches']);
        Permission::create(['name' => 'edit pollbunches']);
        Permission::create(['name' => 'delete pollbunches']);
        Permission::create(['name' => 'publish pollbunches']);

        Permission::create(['name' => 'use blocker']);
        Permission::create(['name' => 'use republisher']);
        Permission::create(['name' => 'use pdf-generator']);

        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'assign permissions']);

        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'assign roles']);

        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'delete posts']);

        Permission::create(['name' => 'view points']);
        Permission::create(['name' => 'edit points']);
        Permission::create(['name' => 'nullify points']);
        Permission::create(['name' => 'adjust points']);

        Role::create(['name' => 'noname']);

        Role::create(['name' => 'user'])->givePermissionTo([
            'view profiles',
            'view rating',
            'view practices',
            'create practices',
            'edit practices',
            'delete practices',
            'publish practices',
            'view pollbunches',
            'create pollbunches',
            'edit pollbunches',
            'delete pollbunches',
            'publish pollbunches',
            'view posts',
            'use blocker',
            'use republisher',
            'use pdf-generator',
        ]);

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}
