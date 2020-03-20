<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Reposiories\TournamentRepository;
use Illuminate\Support\Facades\DB;

class TournamentService
{
    /**
     * @var TournamentRepository
     */
    private $tournamentRepository;
    /**
     * @var PlayGenerator
     */
    private $playGenerator;

    public function __construct(TournamentRepository $tournamentRepository, PlayGenerator $playGenerator)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->playGenerator = $playGenerator;
    }

    public function createTournament(array $teamIds): Tournament
    {
        $plays = $this->playGenerator->generateDivisionPlays($teamIds);
        $tournamentTeams = array_map(function($teamId) {
            return new TournamentTeam(['team_id' => $teamId]);
        }, $teamIds);

        return DB::transaction(function() use ($plays, $tournamentTeams) {
            /**@var $tournament Tournament*/
            $tournament = $this->tournamentRepository->create([]);

            $tournament->tournamentTeam()->saveMany($tournamentTeams);

            $tournament->plays()->saveMany($plays);

            return $tournament;
        });
    }

    public function createPlayOffPlays(Tournament $tournament): array
    {
        $plays = $this->playGenerator->generatePlayOffPlays($tournament);

        if (count($plays) > 0) {

            DB::transaction(function () use ($plays, $tournament) {

                $this->tournamentRepository->update(['step' => $tournament->step + 1], $tournament->id);

                $tournament->plays()->saveMany($plays);

            });

        }

        return $plays;
    }

}
