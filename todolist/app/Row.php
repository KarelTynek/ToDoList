<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    protected $primaryKey = 'id_row';

    protected $fillable = [
        'description',
    ];

    protected $hidden = [
        'id_row', 'fk_column',
    ];
}
