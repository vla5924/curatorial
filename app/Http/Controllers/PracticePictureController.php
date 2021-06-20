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

    const MAX_SIZE = 1024 * 1024;
    const MAX_SIZE_READABLE = '1 MB';

    public function store(Practice $practice, UploadedFile $file)
    {
        $realName = $file->getClientOriginalName();
        $mime = $file->getMimeType();
        if (!in_array($mime, ['image/png', 'image/jpeg']))
            throw new ErrorException(__('practice.file_format_not_supported', ['mime' => $mime, 'file' => $realName]));
        $size = $file->getSize();
        if ($size > self::MAX_SIZE)
            throw new ErrorException(__('practice.file_too_large', ['file' => $realName, 'max_size' => self::MAX_SIZE_READABLE]));

        $path = $file->storePublicly(self::FILES_DIR);
        $picture = new PracticePicture();
        $picture->practice_id = $practice->id;
        $picture->path = $path;
        $picture->save();
    }

    public function setAnswer(int $pictureId, ?string $answer = null)
    {
        $picture = PracticePicture::where('id', $pictureId)->first();
        if ($picture) {
            $picture->answer = $answer;
            $picture->save();
        }
    }
}
