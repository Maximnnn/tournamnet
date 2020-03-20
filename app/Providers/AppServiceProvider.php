<?php

namespace App\Providers;

use App\Models\Division;
use App\Models\Play;
use App\Models\Team;
use App\Models\Tournament;
use App\Reposiories\DivisionRepository;
use App\Reposiories\PlayRepository;
use App\Reposiories\TeamRepository;
use App\Reposiories\TournamentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TournamentRepository::class, function() {
            return new TournamentRepository(new Tournament());
        });
        $this->app->bind(TeamRepository::class, function() {
            return new TeamRepository(new Team());
        });
        $this->app->bind(PlayRepository::class, function() {
            return new PlayRepository(new Play());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
