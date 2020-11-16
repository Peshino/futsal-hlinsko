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
    Route::resource('matches', 'MatchController');
    Route::resource('rules', 'RuleController');
    Route::get('schedule', 'MatchController@scheduleIndex')->name('matches.schedule-index');
});

Route::prefix('admin')->group(function () {
    Route::get('competitions/{competition}', 'CompetitionController@adminShow')->name('competitions.admin-show');

    Route::prefix('competitions/{competition}')->group(function () {
        Route::get('rules/{rule}', 'RuleController@adminShow')->name('rules.admin-show');
        Route::get('teams/{team}', 'TeamController@adminShow')->name('teams.admin-show');
    });
});
