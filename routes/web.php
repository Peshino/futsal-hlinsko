<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'IntroductionController@index');

Route::get('home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('seasons', 'SeasonController');

Route::resource('competitions', 'CompetitionController');
Route::get('competitions/season/{season}', 'CompetitionController@getCompetitionsBySeason')->name('competitions-by-season');

Route::resource('competition-types', 'CompetitionTypeController');

Route::resource('competition-styles', 'CompetitionStyleController');
