<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    protected $primaryKey = 'id_row';

    protected $fillable = [
        'description', 'priority',
    ];

    protected $hidden = [
        'id_row', 'fk_column',
    ];

    public static function getRows($id) {
        return Self::select('rows.description', 'fk_column', 'id_row', 'priority')
            ->join('columns', 'id_column', '=', 'fk_column')
            ->join('projects', 'id_project', '=', 'fk_project')
            ->where('id_project', $id)
            ->get();
    }
}
