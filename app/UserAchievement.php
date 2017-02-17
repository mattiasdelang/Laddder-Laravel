<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    protected $table = 'user_achievements';

    public function notification()
    {

       return $this->morphOne('App\Activity', 'source');

    }

    public function user()
    {
        return $this->belongsTo('App\User', 'userId');
    }

    public function achievement()
    {
        return $this->belongsTo('App\Achievement', 'achievementId');
    }

}
