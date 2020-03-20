<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TournamentController@index');

Route::get('/tournaments/list', 'TournamentController@list');
Route::get('/tournament/{id}', 'TournamentController@tournament');
Route::get('/create', 'TournamentController@createPage');
Route::post('/tournament/create', 'TournamentController@create');
Route::post('/tournament/generatePlays/{tournament}', 'TournamentController@createPlayOffPlays');

Route::post('/team/create', 'TeamController@create');
Route::get('/team/list', 'TeamController@list');

Route::post('/play/update', 'PlayController@updatePlay');
Route::post('/play/end/{id}', 'PlayController@endGame');

