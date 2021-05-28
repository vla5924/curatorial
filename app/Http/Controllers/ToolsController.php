<?php

namespace App\Http\Controllers;

use App\Http\Services\RepublisherService;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index()
    {
        //
    }

    public function blocker()
    {
        return view('pages.tools.blocker');
    }

    public function republisher()
    {
        $service = new RepublisherService;
        $groups = [];
        try {
            $groups = $service->getGroups();
        } catch (VkException $e) {
            return $e->getMessage();
        }

        return view('pages.tools.republisher', [
            'groups' => $groups,
        ]);
    }
}
