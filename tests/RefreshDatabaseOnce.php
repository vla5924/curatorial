<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

trait RefreshDatabaseOnce
{
    protected static $databaseRefreshed = false;

    public function refreshDatabaseOnce(): void
    {
        if (!static::$databaseRefreshed) {
            Artisan::call('migrate:fresh', ['--env' => 'testing']);
            Artisan::call('db:seed', ['--class' => 'PermissionSeeder', '--env' => 'testing']);
            static::$databaseRefreshed = true;
        }
    }
}
