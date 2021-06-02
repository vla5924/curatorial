<?php

namespace App\Http\Controllers;

use App\Http\Services\RepublisherService;
use App\Models\User;
use ATehnix\VkClient\Exceptions\VkException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolsController extends Controller
{
    public function index()
    {
        //
    }

    public function blocker()
    {
        $user = User::find(Auth::user()->id);

        return view('pages.tools.blocker', [
            'groups' => $user->groups,
        ]);
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
