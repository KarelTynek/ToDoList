<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;

class UserController extends Controller
{
    public function profile() {
        dd(Self::getUserProjects());
    }

    private function getUserProjects() {
        return App\Project::select('title', 'created_at', 'updated_at', 'name', 'id_project')
            ->join('user_projects', 'fk_project', '=', 'id_project')
            ->where('fk_user', Auth::id())
            ->get();
    }
}
