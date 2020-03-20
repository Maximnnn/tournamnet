<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreateRequest;
use App\Models\Team;
use App\Reposiories\TeamRepository;

class TeamController extends Controller
{
    public function create(TeamRepository $teamRepository, TeamCreateRequest $request)
    {
        return $teamRepository->create($request->validated());
    }

    public function list()
    {
        return Team::all();
    }
}
