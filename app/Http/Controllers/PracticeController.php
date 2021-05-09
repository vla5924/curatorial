<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Practice;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    private function groupsOrdered()
    {
        return Group::orderBy('name')->get();
    }

    public function all()
    {
        $practices = Practice::paginate(5);

        return view('pages.practice.index', [
            'groups' => $this->groupsOrdered(),
            'practices' => $practices,
        ]);
    }

    public function byGroup($groupAlias)
    {
        $group = Group::where('alias', $groupAlias)->first();

        return view('pages.practice.index', [
            'groups' => $this->groupsOrdered(),
            'practices' => $group->practices()->paginate(5),
        ]);
    }

    public function single($id)
    {
        $practice = Practice::where('id', $id)->first();

        return view('pages.practice.single', [
            'groups' => $this->groupsOrdered(),
            'practice' => $practice,
        ]);
    }
}
