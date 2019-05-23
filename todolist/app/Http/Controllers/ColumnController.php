<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ColumnController extends Controller
{
    public function destroy(Request $request) {
        $column = App\Column::find($request->input('id'));

        if ($column) $column->delete();

        return back();
    }
}
