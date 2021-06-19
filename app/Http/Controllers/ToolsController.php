<?php

namespace App\Http\Controllers;

use App\Http\Services\PdfGeneratorService;
use App\Http\Services\UserService;
use App\Http\Services\VkTokenService;
use App\Models\User;
use ATehnix\VkClient\Exceptions\VkException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolsController extends Controller
{
    public function index()
    {
        abort(404);
    }

    public function blocker()
    {
        $user = User::find(Auth::user()->id);

        return view('pages.tools.blocker', [
            'groups' => $user->groups,
            'has_extra_token' => VkTokenService::hasExtraToken(),
        ]);
    }

    public function republisher()
    {
        $groups = [];
        try {
            $service = new UserService;
            $groups = $service->getGroups();
        } catch (VkException $e) {
            return $e->getMessage();
        }

        return view('pages.tools.republisher', [
            'groups' => $groups,
            'has_extra_token' => VkTokenService::hasExtraToken(),
        ]);
    }

    public function pdfGenerator()
    {
        return view('pages.tools.pdf-generator');
    }

    public function generatePdf(Request $request)
    {
        $request->validate([
            'vk_post_ids' => 'required',
        ]);

        try {
            $service = new PdfGeneratorService;
            $service->generate($request->vk_post_ids);
        } catch (Exception $e) {
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }
}
