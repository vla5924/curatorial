<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

$databaseRefreshedBeforeTesting = false;

trait RefreshDatabaseOnce
{
    public function refreshDatabaseOnce(): void
    {
        global $databaseRefreshedBeforeTesting;
        if (!$databaseRefreshedBeforeTesting) {
            Artisan::call('migrate:fresh', ['--env' => 'testing']);
            Artisan::call('db:seed', ['--class' => 'PermissionSeeder', '--env' => 'testing']);
            $databaseRefreshedBeforeTesting = true;
        }
    }
}
