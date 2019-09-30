<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $primaryKey = 'id_column';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'id_column', 'fk_project',
    ];

    public static function getColumns($id) {
        return Self::select('name', 'id_column')
            ->where('fk_project', $id)
            ->get();
    }
}
