<?php

namespace App\Helpers;

use App\Models\Practice;
use Illuminate\Support\Facades\Storage;

class PracticeHelper
{
    public static function deepDestroy(Practice $practice)
    {
        foreach ($practice->pictures as $picture) {
            Storage::delete($picture->path);
            $picture->delete();
        }
        $practice->delete();
    }
}
