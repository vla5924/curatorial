<?php

namespace App\Http\Controllers;

use App\Models\Pollbunch;
use Illuminate\Http\Request;

class PollbunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.pollbunches.create');
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
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function show(Pollbunch $pollbunch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function edit(Pollbunch $pollbunch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pollbunch $pollbunch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pollbunch $pollbunch)
    {
        //
    }
}
