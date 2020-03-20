<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTournamentRequest;
use App\Models\PlayType;
use App\Models\Tournament;
use App\Services\TournamentService;

class TournamentController extends Controller
{
    public function index()
    {
        return view('tournaments');
    }

    public function createPage()
    {
        return view('create');
    }

    public function tournament(int $id)
    {
        return view('tournament', [
            'tournament' => Tournament::query()
                ->where('id', $id)->with('plays')->with('teams')->firstOrFail(),
            'types' => PlayType::all()
        ]);
    }

    public function create(TournamentService $tournamentService, CreateTournamentRequest $request)
    {
        return $tournamentService->createTournament(array_values($request->get('teams')));
    }

    public function list()
    {
        return Tournament::query()->paginate(20);
    }

    public function createPlayOffPlays(TournamentService $tournamentService, Tournament $tournament)
    {
        return $tournamentService->createPlayOffPlays($tournament);
    }

}
