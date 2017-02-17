<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    protected $primaryKey = 'userInviteId';
    protected $table = 'users_invites';
}
