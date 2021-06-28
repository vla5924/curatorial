<?php

namespace App\Http\Controllers;

class HelpController extends Controller
{
    public function index()
    {
        $answerMarkers = VkWebhookController::ANSWER_TEXT_MARKERS;

        return view('pages.help.index', [
            'answer_markers' => $answerMarkers,
        ]);
    }

    public function about()
    {
        return view('pages.help.about');
    }
}
