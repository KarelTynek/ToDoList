<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;

class ProjectController extends Controller
{
    public function create() {
        dd(Auth::id());

        return view('project.create', ['types' => Self::getTypes()]);
    }

    public function store(Request $request) {
        $project = new App\Project;
        $project->title = $request->input('title');
        $project->description = $request->input('desc');
        $project->owner = Auth::id();
        $project->fk_type = $request->input('type');
        $project->save();

        return back();
    }

    private function getTypes() {
        return App\Type::all();
    }
}
