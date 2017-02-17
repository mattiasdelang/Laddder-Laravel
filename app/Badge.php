<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $table = 'badges';
    public $timestamps = false;
    protected $fillable = ['name','img'];

}
