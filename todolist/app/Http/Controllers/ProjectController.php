<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests as FormRequest;
use App;
use Auth;

class ProjectController extends Controller
{
    public function create() {
        return view('project.create');
    }

    public function store(FormRequest\CreateProject $request) {
        $request->validated();
        
        $project = new App\Project;
        $project->title = $request->input('title');
        $project->description = $request->input('desc');
        $project->owner = Auth::id();
        $project->type = $request->input('type');
        $project->save();

        $user_project = new App\user_project;
        $user_project->fk_user = Auth::id();
        $user_project->fk_project = Self::getProjectId()->id_project;
        $user_project->save();

        flash('Projekt byl vytvořen.');

       return redirect()->route('profile');
    }

    public function show($id) {
       if (!App\Project::find($id)) return redirect()->route('profile');;

       return view('project.show', [
           'project' => $id, 
           'columns' => App\Column::getColumns($id),
           'projectData' => Self::getProjectData($id),
           'rows' => App\Row::getRows($id)
       ]);
    }

    public function share(Request $request) {
        $user = App\User::where('email', $request->input('email'))->first();
        if (!$user) {
            flash('Uživatel s emailem ' . $request->input('email') . ' nebyl nalezen.')->warning();
            return back();
        } else if (Auth::user()->email == $request->input('email')) {
            flash('Sdílení selhalo. Tento projekt vlastníte.')->warning();
            return back();
        }

        if (App\user_project::where('fk_user', $user->id)->where('fk_project', $request->input('project'))->first()) {
            flash('Tento projekt již je sdílený s uživatelem ' . $user->name . '.')->warning();
            return back();
        } else {
            $userProject = new App\user_project;
            $userProject->fk_user = $user->id;
            $userProject->fk_project = $request->input('project');
            $userProject->save();
    
            flash('Projekt sdílen s uživatelem ' . $user->name . '.');
            return back();
        }
    }

    private function getProjectData($id) {
        return App\Project::select('title', 'description', 'owner')
            ->where('id_project', $id)
            ->first();
    }

    private function getProjectId() {
        return App\Project::select('id_project')
            ->where('owner', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
