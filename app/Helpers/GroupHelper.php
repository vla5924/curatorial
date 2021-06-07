<?php

namespace App\Helpers;

use App\Models\Group;

class GroupHelper
{
    public static function ordered()
    {
        return Group::orderBy('name');
    }

    public static function imagePublicPath(Group $group)
    {
        $path = \public_path('images') . DIRECTORY_SEPARATOR . 'groups' . DIRECTORY_SEPARATOR . $group->alias . '.png';
        $publicPath = '/images/groups/' . $group->alias . '.png';

        return file_exists($path) ? $publicPath : null;
    }

    public static function imageTag(Group $group, int $height, string $classes = null)
    {
        $path = self::imagePublicPath($group);
        $classes = $classes ? ' class="' . $classes . '"' : '';
        if ($path)
            return '<img src="' . $path . '" title="' . $group->name . '" alt="' . $group->name . '" height="' . $height . '"' . $classes . '>';
        return '';
    }
}
