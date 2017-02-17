<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFlag extends Model
{
    protected $table = 'flags';
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function notification()
    {
        return $this->morphOne('App\Activity', 'source');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'projectId');
    }


    public function user()
    {
        return $this->belongsTo('App\User', 'userId');
    }

}
