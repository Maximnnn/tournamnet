<?php

namespace App\Services;

use App\Models\Play;
use App\Models\PlayType;
use App\Models\Tournament;
use App\Reposiories\PlayRepository;

class PlayGenerator
{
    /**
     * @var PlayRepository
     */
    private $playRepository;

    public function __construct(PlayRepository $playRepository)
    {
        $this->playRepository = $playRepository;
    }

    public function generateDivisionPlays(array $teamIds): array
    {
        $plays = [];
        $divisions = $this->separateTeamsToDivisions($teamIds);

        foreach ($divisions['A'] as $aTeam) {
            foreach ($divisions['B'] as $bTeam) {
                $plays[] = new Play([
                    'play_type_id' => PlayType::id('division'),
                    'team_left' => $aTeam,
                    'team_right' => $bTeam,
                    'step' => 0
                ]);
            }
        }

        return $plays;
    }

    protected function separateTeamsToDivisions($teamIds): array
    {
        $divisions = [
            'A' => [],
            'B' => []
        ];

        foreach ($teamIds as $key => $teamId) {
            if ($key % 2 === 0) {
                $divisions['A'][] = $teamId;
            } else {
                $divisions['B'][] = $teamId;
            }
        }

        return $divisions;
    }

    public function generatePlayOffPlays(Tournament $tournament): array
    {
        $this->checkPreviousPlaysFinished($tournament);

        $teams = $this->playRepository->getTeamsForPlayOff($tournament);
        $plays = [];

        if (count($teams) > 1) {
            for ($i = 0; $i < count($teams); $i += 2) {
                $plays[] = new Play([
                    'tournament_id' => $tournament->id,
                    'play_type_id' => PlayType::id('playOff'),
                    'team_left' => $teams[$i],
                    'team_right' => $teams[$i + 1],
                    'step' => $tournament->step + 1,
                    'finished' => false
                ]);
            }
        }

        return $plays;
    }

    private function checkPreviousPlaysFinished(Tournament $tournament)
    {
        $notFinished = $tournament->plays()->where('finished', false)->count();

        if ($notFinished) {
            throw new PlayException('previous plays not finished');
        }
    }
}
