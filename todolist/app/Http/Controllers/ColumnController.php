<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests as FormRequest;
use App;

class ColumnController extends Controller
{
    public function destroy($id) {
        $column = App\Column::find($id);
        
        if ($column) $column->delete();

        return back();
    }

    public function add(FormRequest\NewColumn $request) {
        $request->validated();

        $column = new App\Column;
        $column->name = $request->input('name');
        $column->fk_project = $request->input('project');
        $column->save();
    }

    public function reload(Request $request) {
        $view = view('project.columns', [
            'columns' => App\Column::getColumns($request->input('id')),
            'rows' => App\Row::getRows($request->input('id'))
            ])->render();

        return response()->json(compact('view'));
    }

    public function rename(Request $request) {
        App\Column::where('id_column', $request->input('id'))->update([
            'name' => $request->input('title')
        ]);

        return response()->json("Renamed");
    }

}
