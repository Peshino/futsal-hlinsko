<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'IntroductionController@index');

Route::get('home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('seasons', 'SeasonController');

Route::resource('competitions', 'CompetitionController', ['except' => [
    'create', 'edit'
]]);
Route::get('competitions/season/{season}', 'CompetitionController@getCompetitionsBySeason')->name('competitions-by-season');
Route::get('competitions/create/{season}', 'CompetitionController@create')->name('competitions.create');
Route::get('competitions/{competition}edit/{season}', 'CompetitionController@edit')->name('competitions.edit');

Route::resource('competition-styles', 'CompetitionStyleController');

Route::prefix('competitions/{competition}')->group(function () {
    Route::resource('teams', 'TeamController');
    Route::resource('rules', 'RuleController');
    Route::resource('goals', 'GoalController');
    Route::resource('cards', 'CardController');

    Route::prefix('teams/{team}')->group(function () {
        Route::resource('players', 'PlayerController', ['except' => [
            'index'
        ]]);

        Route::get('{section?}', 'TeamController@show')->name('team-section'); // must be the last one
    });

    Route::resource('games', 'GameController', ['except' => [
        'index'
    ]]);

    Route::get('games/create/rules/{rule}', 'GameController@create')->name('games-rule.create');
    Route::post('games/store/rules/{rule}', 'GameController@store')->name('games-rule.store');
    Route::get('results/rules/{rule}/rounds/{round?}', 'GameController@resultsParamsIndex')->name('results.params-index');
    Route::get('schedule/rules/{rule}/rounds/{round?}', 'GameController@scheduleParamsIndex')->name('schedule.params-index');
    Route::get('table/rules/{rule}/rounds/{round?}', 'GameController@tableParamsIndex')->name('table.params-index');
    Route::get('brackets/rules/{rule}/rounds/{round?}', 'GameController@bracketsParamsIndex')->name('brackets.params-index');
    Route::get('goals/rules/{rule}', 'GoalController@index')->name('goals.rule-index');
    Route::get('goals/rules/{rule}/teams/{team}', 'GoalController@index')->name('goals.team-index');
    Route::get('cards/rules/{rule}', 'CardController@index')->name('cards.rule-index');
    Route::get('cards/rules/{rule}/teams/{team}', 'CardController@index')->name('cards.team-index');
    Route::get('{section}/rule/{rule?}', 'GameController@index')->name('games.index'); // must be the last one
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
