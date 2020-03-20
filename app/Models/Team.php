<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $table = 'teams';

    protected $fillable = ['name'];

    public $timestamps = false;
}
