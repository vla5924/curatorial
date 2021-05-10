<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Practice;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function test()
    {
        return ['ok' => true];
    }

    public function publish(int $id, Request $request)
    {
        $practice = Practice::where('id', $id)->first();
    }
}
