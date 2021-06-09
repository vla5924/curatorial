<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    const SUPPORTED_LOCALES = [
        'ru' => 'Русский',
        'en' => 'English',
    ];
    const DEFAULT_LOCALE = 'ru';

    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();

        return view('pages.settings.index', [
            'user' => $user,
            'locales' => self::SUPPORTED_LOCALES,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'locale' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        if (\in_array($request->locale, array_keys(self::SUPPORTED_LOCALES)))
            $user->locale = $request->locale;
        else
            $user->locale = self::DEFAULT_LOCALE;
        $user->save();

        return redirect()->back()->withSuccess(__('settings.settings_saved', [], $user->locale));
    }
}
