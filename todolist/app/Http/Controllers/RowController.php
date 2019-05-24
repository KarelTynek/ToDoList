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
}
