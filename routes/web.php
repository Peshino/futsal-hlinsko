<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'IntroductionController@index');

Route::get('home', 'HomeController@index')->name('home');

Route::resource('uzivatele', 'UserController');

Route::resource('sezony', 'SeasonController');

Route::resource('souteze', 'CompetitionController');
Route::get('souteze/sezona/{sezona}', 'CompetitionController@getCompetitionsBySeason')->name('competitions-by-season');

Route::resource('souteze-typy', 'CompetitionTypeController');

Route::resource('souteze-styly', 'CompetitionStyleController');
