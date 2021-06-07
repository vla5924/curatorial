<?php

namespace App\Http\Controllers;

use App\Http\Services\VkTokenService;
use App\Models\Group;
use App\Models\Practice;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PracticeController extends Controller
{
    const FILES_COUNT_MIN = 1;
    const FILES_COUNT_MAX = 12;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $practices = Practice::orderBy('created_at', 'desc')->paginate(5);

        return view('pages.practice.index', [
            'practices' => $practices,
        ]);
    }

    public function my()
    {
        $practices = Practice::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);

        return view('pages.practice.index', [
            'practices' => $practices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.practice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $practice = new Practice;
        $practice->name = $request->name;
        $practice->group_id = $request->group_id;
        $practice->user_id = Auth::user()->id;

        $files = $request->file('pictures', []);
        if ($files instanceof UploadedFile)
            $files = [$files];
        if (count($files) > 12 or empty($files)) {
            return redirect()->back()->with('failure', __('practice.choose_n_files', ['min' => self::FILES_COUNT_MIN, 'max' => self::FILES_COUNT_MAX]));
        }

        $practice->save();
        $controller = new PracticePictureController;
        try {
            foreach ($files as $file) {
                $controller->store($practice, $file);
            }
        } catch (ErrorException $e) {
            $practice->delete();
            return redirect()->back()->with('failure', $e->getMessage());
        }

        return redirect()->route('practice.show', $practice->id)->with('success', __('practice.practice_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function show(Practice $practice)
    {
        return view('pages.practice.show', [
            'practice' => $practice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function edit(Practice $practice)
    {
        return view('pages.practice.edit', [
            'practice' => $practice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Practice $practice)
    {
        $practice->name = $request->name;
        $practice->group_id = $request->group_id;
        $practice->save();

        return redirect()->back()->withSuccess(__('practice.practice_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practice $practice)
    {
        foreach ($practice->pictures as $picture) {
            Storage::delete($picture->path);
            $picture->delete();
        }
        $practice->delete();

        return redirect()->route('practice.index')->with('success', __('practice.practice_deleted_successfully'));
    }

    public function publish(int $id)
    {
        $practice = Practice::where('id', $id)->first();

        return view('pages.practice.publish', [
            'practice' => $practice,
            'has_extra_token' => VkTokenService::hasExtraToken(),
        ]);
    }
}
