<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ColumnController extends Controller
{
    public function destroy($id) {
        $column = App\Column::find($id);
        
        if ($column) $column->delete();

        return back();
    }

    public function reload(Request $request) {
        $view = view('project.columns', ['columns' => App\Column::getColumns($request->input('id'))])->render();

        return response()->json(compact('view'));
    }

}
