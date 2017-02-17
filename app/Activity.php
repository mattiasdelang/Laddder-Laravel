<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $fillable = array('userId','projectId','type','comment');

    public function source()
    {
        return $this->morphTo('source');
    }

    public static function markAllAsSeen(User $user)
    {
        \DB::table('activities')
            ->where('userId', $user->userId)
            ->update(array('seen' => 1));
    }


}
