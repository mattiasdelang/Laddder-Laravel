<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{

    protected $table = 'advertisements';
    protected $primaryKey = 'adId';

    public function user() {
        return $this->belongsTo('App\User', 'userId');
    }

}