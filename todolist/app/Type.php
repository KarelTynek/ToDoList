<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $primaryKey = 'id_type';
    public $timestamps = false;

    protected $hidden = [
        'id_type', 'name',
    ];
}
