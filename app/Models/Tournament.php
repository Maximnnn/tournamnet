<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tournament
 * @package App\Models
 * @property $id int
 * @property $step int
 */
class Tournament extends Model
{
    public $table = 'tournaments';

    protected $fillable = ['step'];

    public function tournamentTeam()
    {
        return $this->hasMany(TournamentTeam::class);
    }

    public function plays()
    {
        return $this->hasMany(Play::class);
    }

    public function teams()
    {
        return $this->hasManyThrough(
            Team::class, TournamentTeam::class, 'tournament_id', 'id','id','team_id'
        );
    }
}
