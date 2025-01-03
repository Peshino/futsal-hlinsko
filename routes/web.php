<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\GameRegistrationTemplateController;
use App\Http\Controllers\IntroductionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\CompetitionStyleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\LeaderboardController;

Auth::routes();

Route::get('/', [IntroductionController::class, 'index'])->name('introduction');

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);

Route::resource('seasons', SeasonController::class);

Route::resource('competitions', CompetitionController::class, ['except' => [
    'create', 'edit'
]]);

Route::get('competitions/season/{season}', [CompetitionController::class, 'getCompetitionsBySeason'])->name('competitions-by-season');
Route::get('competitions/create/{season}', [CompetitionController::class, 'create'])->name('competitions.create');
Route::get('competitions/{competition}/edit/{season}', [CompetitionController::class, 'edit'])->name('competitions.edit');

Route::resource('competition-styles', CompetitionStyleController::class);

Route::prefix('competitions/{competition}')->group(function () {
    Route::resource('teams', TeamController::class);
    Route::resource('rules', RuleController::class);
    Route::resource('goals', GoalController::class);
    Route::resource('cards', CardController::class);

    Route::prefix('teams/{team}')->group(function () {
        Route::resource('players', PlayerController::class, ['except' => [
            'index'
        ]]);

        Route::get('{section?}', [TeamController::class, 'show'])->name('team-section'); // must be the last one
    });

    Route::resource('games', GameController::class, ['except' => [
        'index'
    ]]);

    Route::middleware(['auth'])->group(function () {
        Route::get('/predictions/rules/{rule}/rounds/{round?}', [PredictionController::class, 'index'])->name('predictions.index');
        Route::post('/predictions', [PredictionController::class, 'store'])->name('predictions.store');
    });

    Route::get('/leaderboard/index', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/leaderboard/weekly', [LeaderboardController::class, 'weekly'])->name('leaderboard.weekly');
    Route::get('/leaderboard/monthly', [LeaderboardController::class, 'monthly'])->name('leaderboard.monthly');

    Route::get('games/create/rules/{rule}', [GameController::class, 'create'])->name('games-rule.create');
    Route::post('games/store/rules/{rule}', [GameController::class, 'store'])->name('games-rule.store');
    Route::get('results/rules/{rule}/rounds/{round?}', [GameController::class, 'resultsParamsIndex'])->name('results.params-index');
    Route::get('schedule/rules/{rule}/rounds/{round?}', [GameController::class, 'scheduleParamsIndex'])->name('schedule.params-index');
    Route::get('table/rules/{rule}/rounds/{round?}', [GameController::class, 'tableParamsIndex'])->name('table.params-index');
    Route::get('brackets/rules/{rule}/rounds/{round?}', [GameController::class, 'bracketsParamsIndex'])->name('brackets.params-index');
    Route::get('goals/rules/{rule}', [GoalController::class, 'index'])->name('goals.rule-index');
    Route::get('goals/rules/{rule}/teams/{team}', [GoalController::class, 'index'])->name('goals.team-index');
    Route::get('cards/rules/{rule}', [CardController::class, 'index'])->name('cards.rule-index');
    Route::get('cards/rules/{rule}/teams/{team}', [CardController::class, 'index'])->name('cards.team-index');
    Route::get('{section}/rule/{rule?}', [GameController::class, 'index'])->name('games.index'); // must be the last one
});

Route::prefix('admin')->middleware('can:manage_admin_routes')->group(function () {
    Route::get('seasons/{season}', [SeasonController::class, 'show'])->name('seasons.admin-show');
    Route::get('competitions/{competition}', [CompetitionController::class, 'adminShow'])->name('competitions.admin-show');

    Route::prefix('competitions/{competition}')->group(function () {
        Route::get('rules/{rule}', [RuleController::class, 'adminShow'])->name('rules.admin-show');
        Route::get('teams/{team}', [TeamController::class, 'adminShow'])->name('teams.admin-show');

        Route::prefix('teams/{team}')->group(function () {
            Route::get('players/{player}', [PlayerController::class, 'adminShow'])->name('players.admin-show');
        });

        Route::post('players-synchronize', [PlayerController::class, 'sync'])->name('players-synchronize');
    });

    Route::get('game-registration-template/competitions/{competition}/rules/{rule?}', [GameRegistrationTemplateController::class, 'index'])->name('game-registration-template');

    Route::get('recalculate-leaderboard/{round}', [LeaderboardController::class, 'recalculate'])->name('admin.recalculate-leaderboard');

    Route::get('clear-all-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:cache');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:cache');

        return redirect('/');
    });

    Route::get('make-storage-link', function () {
        Artisan::call('storage:link');

        return redirect('/');
    });
});
