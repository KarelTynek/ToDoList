<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;

class UserController extends Controller
{
    public function profile() {
        return view('profile', ['projects' => Self::getUserProjects()]);
    }

    private function getUserProjects() {
        return App\Project::select('title','updated_at', 'id_project', 'description')
            ->join('user_projects', 'fk_project', '=', 'id_project')
            ->where('fk_user', Auth::id())
            ->paginate(10);
    }
}
