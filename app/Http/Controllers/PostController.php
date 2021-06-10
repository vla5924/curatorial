<?php

namespace App\Http\Controllers;

use App\Helpers\GroupHelper;
use App\Helpers\UserHelper;
use App\Models\Post;
use App\Models\UnansweredPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = [
            'creator_id' => $request->has('creator_id') ? (int)$request->creator_id : 0,
            'signer_id' => $request->has('signer_id') ? (int)$request->signer_id : 0,
            'group_id' => $request->has('group_id') ? (int)$request->group_id : 0,
        ];

        $postsQuery = Post::orderBy('created_at', 'desc');
        if ($filters['creator_id'] > 0)
            $postsQuery = $postsQuery->where('creator_id', $filters['creator_id']);
        if ($filters['signer_id'] > 0)
            $postsQuery = $postsQuery->where('signer_id', $filters['signer_id']);
        if ($filters['group_id'] > 0)
            $postsQuery = $postsQuery->where('group_id', $filters['group_id']);
        $posts = $postsQuery->paginate(20);

        $users = UserHelper::activeOrdered()->get();
        $groups = GroupHelper::ordered()->get();

        return view('pages.posts.index', [
            'posts' => $posts,
            'users' => $users,
            'groups' => $groups,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function unanswered()
    {
        $posts = UnansweredPost::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(36);

        return view('pages.posts.unanswered', [
            'posts' => $posts,
        ]);
    }
}
