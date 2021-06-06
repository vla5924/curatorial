<?php

namespace App\Http\Controllers;

use App\Http\Services\VkTokenService;
use App\Models\Pollbunch;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollbunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pollbunches = Pollbunch::orderBy('created_at', 'desc')->paginate(5);

        return view('pages.pollbunches.index', [
            'pollbunches' => $pollbunches,
        ]);
    }

    public function my()
    {
        $pollbunches = Pollbunch::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);

        return view('pages.pollbunches.index', [
            'pollbunches' => $pollbunches,
        ]);
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
        $pollbunch = new Pollbunch;
        $pollbunch->name = $request->name;
        $pollbunch->group_id = $request->group_id;
        $pollbunch->user_id = Auth::user()->id;
        $pollbunch->save();

        $controller = new PollbunchQuestionController;
        try {
            foreach ($request->questions as $questionData)
                $controller->store($pollbunch, $questionData);
        } catch (ErrorException $e) {
            $pollbunch->delete();
            return redirect()->back()->with('failure', $e->getMessage());
        }

        return redirect()->back()->withSuccess('Practice created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function show(Pollbunch $pollbunch)
    {
        return view('pages.pollbunches.show', [
            'pollbunch' => $pollbunch,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function edit(Pollbunch $pollbunch)
    {
        return view('pages.pollbunches.edit', [
            'pollbunch' => $pollbunch,
        ]);
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
        $pollbunch->name = $request->name;
        $pollbunch->group_id = $request->group_id;
        $pollbunch->save();

        return redirect()->back()->withSuccess('Pollbunch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pollbunch  $pollbunch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pollbunch $pollbunch)
    {
        foreach ($pollbunch->questions as $question) {
            foreach ($question->answers as $answer)
                $answer->delete();
            $question->delete();
        }
        $pollbunch->delete();

        return redirect()->back()->withSuccess('Pollbunch deleted successfully');
    }

    public function publish(int $id)
    {
        $pollbunch = Pollbunch::where('id', $id)->first();

        return view('pages.pollbunches.publish', [
            'pollbunch' => $pollbunch,
            'has_extra_token' => VkTokenService::hasExtraToken(),
        ]);
    }
}
