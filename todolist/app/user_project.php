<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_project extends Model
{
    protected $primaryKey = 'id_up';
    public $timestamps = false;

    protected $hidden = [
        'id_pu', 'fk_user', 'fk_project',
    ];
}
