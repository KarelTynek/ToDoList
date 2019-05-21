<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Project extends Model
{
    protected $primaryKey = 'id_project';
    public $incrementing = false;

    protected $fillable = [
        'title', 'description', 'password', 'fk_type',
    ];

    protected $hidden = [
        'id_project', 'created_at', 'updated_at', 'owner',
    ];

    public static function boot() {
        parent::boot();

        self::creating(function($model){
            $model->id_project = self::generateUuid();
        });
    }

    public static function generateUuid() {
        return Uuid::generate();
    }
}
