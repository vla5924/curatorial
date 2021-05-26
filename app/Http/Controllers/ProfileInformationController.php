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
        $user->education = $request->education;
        $user->location = $request->location;
        $user->notes = $request->notes;
        $user->save();

        return redirect()->back()->withSuccess('Your profile information updated successfully.');
    }
}
