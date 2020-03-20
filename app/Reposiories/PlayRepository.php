<?php

namespace App\Reposiories;

use App\Models\Play;
use App\Models\Tournament;
use App\Services\PlayException;
use Illuminate\Support\Facades\DB;

class PlayRepository extends Repository
{
    public function getTeamsForPlayOff(Tournament $tournament): array
    {
        if ($tournament->step == 0) {
            $teams = array_column(DB::select('
                select team_id, sum(score) as score from (
                    select team_left as team_id, score_left as score from plays
                    where tournament_id = ' . $tournament->id . '
                    union all
                    select team_right as team_id, score_right as score from plays
                    where tournament_id = ' . $tournament->id . '
                ) scores
                group by team_id
                order by score desc
                limit 8
                '), 'team_id');
        } else {
            $plays = Play::query()
                ->where('tournament_id', $tournament->id)
                ->where('step', $tournament->step)
                ->get();
            $teams = $plays->map(function(Play $play) {
                return $play->winnerTeamId();
            })->toArray();
        }

        return $teams;
    }

    public function update(array $data, $id)
    {
        $play = Play::query()->findOrFail($id);
        if ($play->finished) {
            throw new PlayException('Play already finished');
        }
        return $play->update($data);
    }
}
