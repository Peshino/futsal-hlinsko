<?php

namespace App\Http\Controllers;

use App\Competition;
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
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'schedule');

        if ($currentRound !== null) {
            $currentRound = (int) $currentRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule', $currentRound);
        } else {
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule');
        }

        return view('predictions.index', compact('competition', 'rule', 'currentRound', 'games', 'rounds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'tip' => 'required|in:home,draw,away',
        ]);

        $prediction = Prediction::updateOrCreate(
            ['user_id' => auth()->id(), 'game_id' => $request->game_id],
            ['tip' => $request->tip]
        );

        session()->flash('flash_message_success', '<i class="fas fa-check"></i>');

        return redirect()->back()->with('flash_message_success', '<i class="fas fa-check"></i> Tip byl uložen.');
    }
}
