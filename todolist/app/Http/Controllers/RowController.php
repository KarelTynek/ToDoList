<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class RowController extends Controller
{
    public function add(Request $request) {
        $row = new App\Row;
        $row->description = $request->input('desc');
        $row->fk_column = $request->input('id');
        $row->save();
    }

    public function edit(Request $request) {
        App\Row::where('id_row', $request->input('id'))->update([
            'description' => $request->input('title')
        ]);

        return response()->json("Description changed");
    }

    public function destroy(Request $request) {
        $row = App\Row::find($request->input('id'));
        
        if ($row) {
            App\Row::where('id_row', $row->id_row)->delete();
            $row->delete();
        }

        return back();
    }
}
