<?php

namespace App\Helpers;

use App\Models\Group;

class GroupHelper
{
    public static function ordered()
    {
        return Group::orderBy('name');
    }
}
