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

        if ($currentRound !== null) {
            $currentRound = (int) $currentRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule', $currentRound);
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

        foreach ($options as $gameId => $tip) {
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

        session()->flash('flash_message_success', '<i class="fas fa-check"></i>');

        return redirect()->back()->with('flash_message_success', '<i class="fas fa-check"></i> Tip byl uložen.');
    }
}
