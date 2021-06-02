<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function test()
    {
        return ['ok' => true];
    }

    public function points(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'points' => 'required',
        ]);

        $post = Post::where('id', $request->post_id)->first();
        $post->points = $request->points;
        $post->points_assigner_id = Auth::user()->id;
        $post->save();

        return ['ok' => true];
    }
}
