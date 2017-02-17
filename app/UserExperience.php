<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $table = 'user_experience';
    protected $primaryKey = 'id';
    protected $fillable = array('userId', 'type', 'xp');

    public static function addStats($id, $type, $amount)
    {

        \DB::table('user_experience')
            ->where('userId', "=", $id)
            ->where('type', '=', $type)
            ->increment('xp', $amount);

        // Fire event so the AchievementsServiceProvider can do it's magic.
        \Event::fire('achievement.updated', [
            'user' => $id, // TODO: change function parameters to (User $user, $type, $amount)
            'type' => $type
        ]);

    }

}
