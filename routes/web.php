<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'IntroductionController@index');

Route::get('home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('seasons', 'SeasonController');

Route::resource('competitions', 'CompetitionController', ['except' => [
    'create'
]]);
Route::get('competitions/season/{season}', 'CompetitionController@getCompetitionsBySeason')->name('competitions-by-season');
Route::get('competitions/create/{season}', 'CompetitionController@create')->name('competitions.create');

Route::resource('competition-styles', 'CompetitionStyleController');

Route::prefix('competitions/{competition}')->group(function () {
    Route::resource('teams', 'TeamController');

    Route::prefix('teams/{team}')->group(function () {
        Route::resource('players', 'PlayerController', ['except' => [
            'index'
        ]]);

        Route::get('players', 'TeamController@getTeamPlayers')->name('team-players');
        Route::get('results', 'TeamController@getTeamResults')->name('team-results');
    });

    Route::resource('matches', 'MatchController', ['except' => [
        'index'
    ]]);
    Route::get('{section}', 'MatchController@index')->name('matches.index');
    Route::get('results/rules/{rule}/rounds/{round}', 'MatchController@resultsParamsIndex')->name('results.params-index');
    Route::get('schedule/rules/{rule}/rounds/{round}', 'MatchController@scheduleParamsIndex')->name('schedule.params-index');
    Route::get('table/rules/{rule}/rounds/{round}', 'MatchController@tableParamsIndex')->name('table.params-index');
    // Route::get('schedule', 'MatchController@scheduleIndex')->name('matches.schedule-index');

    Route::resource('rules', 'RuleController');
});

Route::prefix('admin')->middleware('can:manage_admin_routes')->group(function () {
    Route::get('seasons/{season}', 'SeasonController@show')->name('seasons.show');
    Route::get('competitions/{competition}', 'CompetitionController@adminShow')->name('competitions.admin-show');

    Route::prefix('competitions/{competition}')->group(function () {
        Route::get('rules/{rule}', 'RuleController@adminShow')->name('rules.admin-show');
        Route::get('teams/{team}', 'TeamController@adminShow')->name('teams.admin-show');

        Route::prefix('teams/{team}')->group(function () {
            Route::get('players/{player}', 'PlayerController@adminShow')->name('players.admin-show');
        });
    });
});
