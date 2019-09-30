<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Auth;
use App;

class UserController extends Controller
{
    public function profile(Request $request) {
        try {
            return view('profile', [
                'projects' => Self::getUserProjects($request),
                'private' => Self::getPrivateAmount(),
                'public' => Self::getPublicAmount()
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    private function getUserProjects($request) {
        $query = App\Project::select('title','updated_at', 'id_project', 'description', 'type', 'owner')
            ->join('user_projects', 'fk_project', '=', 'id_project')
            ->where('fk_user', Auth::id());

        if (!empty($request->get("sort"))) {
            // Checks if table has requested column, if not redirects user back with warning
            Schema::table('projects', function (\Illuminate\Database\Schema\Blueprint $table) use ($request, $query) {
                if (Schema::hasColumn('projects', $request->get("sort"))) {
                    $query->orderBy($request->get("sort"), 'desc');
                    if ($request->get("sort") == 'date') $query->orderBy($request->get("updated_at"), 'desc');
                } else {
                    return back();
                }
            });
        }

        return $query->paginate(15);
    }

    private function getPrivateAmount() {
        return App\Project::selectRaw('COUNT(type) as count')
            ->join('user_projects', 'fk_project', '=', 'id_project')
            ->where('type', 1)
            ->where('fk_user', Auth::id())
            ->first();
    }

    private function getPublicAmount() {
        return App\Project::selectRaw('COUNT(type) as count')
            ->join('user_projects', 'fk_project', '=', 'id_project')
            ->where('type', 0)
            ->where('fk_user', Auth::id())
            ->first();
    }
}
