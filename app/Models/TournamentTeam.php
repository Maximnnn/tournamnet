<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class                                                                                                                                                          TournamentTeam extends Model
{
    protected $table = 'tournament_teams';

    protected $fillable = ['tournament_id', 'team_id'];

    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
