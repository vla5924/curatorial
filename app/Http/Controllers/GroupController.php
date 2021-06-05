<?php

namespace App\Http\Controllers;

use App\Helpers\GroupHelper;
use App\Helpers\UserHelper;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = GroupHelper::ordered()->get();

        return view('pages.admin.groups.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->vk_id = $request->vk_id;
        $group->alias = $request->alias;
        $group->save();

        return redirect()->back()->withSuccess('Group added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('pages.admin.groups.edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->name = $request->name;
        $group->vk_id = $request->vk_id;
        $group->alias = $request->alias;
        $group->vk_confirmation_token = $request->vk_confirmation_token;
        $group->save();

        return redirect()->back()->withSuccess('Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->back()->withSuccess('Group deleted successfully');
    }

    public function assign()
    {
        $users = UserHelper::activeOrdered()->paginate(20);
        $groups = GroupHelper::ordered()->get();

        return view('pages.admin.groups.assign', [
            'users' => $users,
            'groups' => $groups,
        ]);
    }
}
