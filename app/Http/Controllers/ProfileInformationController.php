<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileInformationController extends Controller
{
    public function index()
    {
        return view('pages.settings.information');
    }

    public function store(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->education = $request->has('education') ? $request->education : null;
        $user->location = $request->has('location') ? $request->location : null;
        $user->notes = $request->has('notes') ? $request->notes : null;
        $user->save();

        return redirect()->back()->withSuccess(__('settings.information_updated_successfully'));
    }
}
