<?php

namespace App\Http\Services;

use App\Http\Services\VkTokenService;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PdfGeneratorService extends VkApiService
{
    const RENDER_DPI = 120;

    protected static function inches(int $pixels): int
    {
        return ceil($pixels / self::RENDER_DPI);
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function fetchPosts(string $postIds)
    {
        $this->checkToken();
        return $this->callForResponse('wall.getById', [
            'posts' => $postIds,
        ]);
    }

    public function generate(string $postIds)
    {
        $posts = $this->fetchPosts($postIds);

        $pictures = [];
        $realPostIds = [];
        $i = 0;
        foreach ($posts as $post) {
            $hasPhotos = false;
            foreach ($post['attachments'] as $attachment) {
                if ($attachment['type'] != 'photo')
                    continue;

                $hasPhotos = true;

                foreach ($attachment['photo']['sizes'] as $s)
                    $sizes[$s['type']] = $s;
                if (isset($sizes['z'])) $sbig = 'z';
                elseif (isset($sizes['y'])) $sbig = 'y';
                elseif (isset($sizes['x'])) $sbig = 'x';
                elseif (isset($sizes['r'])) $sbig = 'r';
                else continue;

                $picturePath = 'pdf-generator/' . Auth::user()->id . '/' . ($i++) . '.jpg';
                Storage::put($picturePath, file_get_contents($sizes[$sbig]['url']));
                $pictures[] = [
                    'width' => $sizes[$sbig]['width'],
                    'height' => $sizes[$sbig]['height'],
                    'path' => Storage::path($picturePath),
                ];
            }
            if ($hasPhotos)
                $realPostIds[] = $post['owner_id'] . '_' . $post['id'];
        }
        $documentName = 'posts' . implode(',', $realPostIds);

        $maxWidth = $maxHeight = 0;
        foreach ($pictures as $picture) {
            if ($s['width'] > $maxWidth)
                $maxWidth = $s['width'];
            if ($s['height'] > $maxHeight)
                $maxHeight = $s['height'];
        }


        Fpdf::SetTitle($documentName);
        foreach ($pictures as $picture) {
            $pageSizes = [self::inches($maxWidth), self::inches($maxHeight)];
            Fpdf::AddPage('L', $pageSizes);
            Fpdf::Image($picture['path'], 0, 0, self::inches($picture['width']));
            Storage::deleteDirectory('pdf-generator/' . Auth::user()->id);
        }
        Fpdf::Output('I', $documentName . '.pdf');
    }
}
