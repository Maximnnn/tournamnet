<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Play
 * @package App\Models
 * @property $id int
 * @property $score_left int
 * @property $team_left int
 * @property $score_right int
 * @property $team_right int
 * @property $finished bool
 */
class Play extends Model
{
    protected $table = 'plays';

    protected $fillable = ['tournament_id', 'step', 'play_type_id', 'team_left', 'team_right', 'score_left', 'score_right', 'finished'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function teamLeft()
    {
        return $this->belongsTo(Team::class, 'team_left');
    }

    public function teamRight()
    {
        return $this->belongsTo(Team::class, 'team_right');
    }

    public function playType()
    {
        return $this->hasOne(PlayType::class);
    }

    public function winnerTeamId(): int
    {
        return $this->score_right > $this->score_left ? $this->team_right : $this->team_left;
    }
}
