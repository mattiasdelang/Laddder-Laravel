<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReferfriend extends Model
{
    protected $table = 'user_referfriend';

    protected $fillable = ['userId', 'email', 'check'];

    protected $primaryKey = 'id';


}
