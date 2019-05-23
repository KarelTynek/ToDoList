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
}
