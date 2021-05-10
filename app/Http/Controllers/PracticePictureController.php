<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\PracticePicture;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PracticePictureController extends Controller
{
    const FILES_DIR = 'public/practice_pictures';
    const MAX_SIZE = 1024 * 1024; // 1 MB

    public function store(Practice $practice, UploadedFile $file)
    {
        $realName = $file->getClientOriginalName();
        $mime = $file->getMimeType();
        if (!in_array($mime, ['image/png', 'image/jpeg']))
            throw new ErrorException('File format "'. $mime . '" of file "' . $realName . '" is not supported');
        $size = $file->getSize();
        if ($size > self::MAX_SIZE)
            throw new ErrorException('File "' . $realName . '" is too large (must be less than 1 MB)');

        $path = $file->storePublicly(self::FILES_DIR);
        $picture = new PracticePicture();
        $picture->practice_id = $practice->id;
        $picture->path = $path;
        $picture->save();
    }
}
