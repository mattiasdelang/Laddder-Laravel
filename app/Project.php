<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'project_images';
    protected $primaryKey = 'projectId';

    public function user() {
        return $this->belongsTo('App\User', 'userId');
    }

}
