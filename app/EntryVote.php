<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryVote extends Model
{
    protected $table = 'challenge_votes';
    protected $primaryKey = 'id';

}
