<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string<
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $primaryKey = 'userId';


    public function achievements()
    {
        return $this->belongsToMany('App\Achievement','user_achievements', 'userId', 'achievementId')->withTimestamps();
    }

    public function badges()
    {
        return $this->belongsToMany('App\Badge','user_badges', 'userId', 'badgeId')->withTimestamps();
    }

    public function apikey()
    {
        return $this->belongsTo('App\UserApikey', 'userId');
    }

    public function referfriend()
    {
        return $this->belongsTo('App\UserReferfriend', 'userId');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity', 'userId');
    }

    /**
     * Follow
     */

    public function followersOfMine()
    {
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
    }

    public function followersOf()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'user_id');
    }

    public function followers()
    {
        return $this->followersOfMine()->wherePivot('following', true)->get();
    }

    public function following()
    {
        return $this->followersOf()->wherePivot('following', true)->get();
    }

    public function follow(User $user)
    {
        $this->followersOf()->attach($user->userId);
    }

    public function isFollowing(User $user)
    {
        return (bool) $this->following()->where('userId', $user->userId)->count();
    }













}
