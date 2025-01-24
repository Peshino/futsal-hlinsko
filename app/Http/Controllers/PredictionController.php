<?php

namespace App\Http\Controllers;

use App\Competition;
Use App\Prediction;
use App\Rule;
use App\Repositories\Games;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Competition $competition, Rule $rule, $currentRound = null)
    {
        $gamesRepository = new Games;
        $userId = auth()->id();

        if ($currentRound !== null) {
            $currentRound = (int) $currentRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule-from-now', $currentRound);

            // Retrieve the game IDs that the user has already made predictions for
            $predictedGameIds = Prediction::where('user_id', $userId)
                ->whereIn('game_id', $games->pluck('id'))
                ->pluck('game_id')
                ->toArray();

            // Filter out the games that the user has already made predictions for
            $games = $games->filter(function ($game) use ($predictedGameIds) {
                return !in_array($game->id, $predictedGameIds);
            });
        } else {
            $game = $rule->getFirstSchedule();

            if ($game !== null) {
                return redirect()->route('predictions.index', ['competition' => $competition->id, 'rule' => $rule->id, 'round' => $game->round]);
            }
        }

        return view('predictions.index', compact('competition', 'rule', 'currentRound', 'games'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        $options = $request->input('options');
        $startDateTimes = $request->input('startDateTime');

        if ($options === null) {
            return redirect()->back()->with('flash_message_warning', '<i class="fas fa-exclamation-triangle"></i> Nebyly vybrány žádné tipy.');
        }

        foreach ($options as $gameId => $tip) {
            $startDateTime = $startDateTimes[$gameId] ?? null;

            if ($startDateTime !== null && $startDateTime >= now()->timestamp) {
                Prediction::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'game_id' => $gameId,
                    ],
                    [
                        'tip' => $tip,
                    ]
                );
            }
        }

        return redirect()->back()->with('flash_message_success', '<i class="fas fa-check"></i> Tipy úspěšně uloženy.');
    }
}
