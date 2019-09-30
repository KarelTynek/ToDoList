<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class RowController extends Controller
{
    public function add(Request $request) {
        $row = new App\Row;
        $row->description = $request->input('data.desc');
        $row->fk_column = $request->input('data.id');
        $row->priority = $request->input('data.priority');
        $row->save();
    }

    public function edit(Request $request) {
        App\Row::where('id_row', $request->input('data.id'))->update([
            'description' => $request->input('data.desc'),
            'priority' => $request->input('data.priority')
        ]);
    }

    public function destroy(Request $request) {
        $row = App\Row::find($request->input('data.id'));
        
        if ($row) {
            App\Row::where('id_row', $row->id_row)->delete();
            $row->delete();
        }

        return back();
    }
}
