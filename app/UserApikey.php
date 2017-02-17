<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApikey extends Model
{

    protected $table = 'user_apikey';

    protected $fillable = ['userId', 'key', 'calls'];

    protected $primaryKey = 'id';

    public static function checkKey($key)
    {

        $checkKey = UserApikey::where('key',$key)->count();
        //dd($checkKey);

        if($checkKey)
        {
            \DB::table('user_apikey')
                ->where('key', "=", $key)
                ->increment('calls', 1);

            return 'true';

        }
        return 'false';

    }
}
