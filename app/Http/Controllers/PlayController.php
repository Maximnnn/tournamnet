<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayUpdateRequest;
use App\Reposiories\PlayRepository;

class PlayController extends Controller
{
    public function updatePlay(PlayUpdateRequest $request, PlayRepository $playRepository)
    {
        return $playRepository->update($request->validated(), $request->get('id'));
    }

    public function endGame(PlayRepository $playRepository, int $id)
    {
        return $playRepository->update(['finished' => true], $id);
    }
}
