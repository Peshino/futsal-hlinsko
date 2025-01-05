<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Prediction;
use App\Rule;
use App\User;
use App\Repositories\Games;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Competition $competition)
    {
        $data = User::select('firstname', 'lastname')
                    ->withSum('predictions', 'points')
                    ->having('predictions_sum_points', '>', 0)
                    ->orderBy('predictions_sum_points', 'desc')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'firstname' => $user->firstname,
                            'lastname' => $user->lastname,
                            'points' => $user->predictions_sum_points,
                        ];
                    })
                    ->toArray();

        return view('leaderboards.index', compact('data', 'competition'));
    }

    public function weekly()
    {
        $users = User::select('firstname', 'lastname')
                    ->withSum(['predictions' => function ($query) {
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    }], 'points')
                    ->having('predictions_sum_points', '>', 0)
                    ->orderBy('predictions_sum_points', 'desc')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'firstname' => $user->firstname,
                            'lastname' => $user->lastname,
                            'points' => $user->predictions_sum_points,
                        ];
                    })
                    ->toArray();

        return view('leaderboards.weekly', compact('users'));
    }

    public function monthly()
    {
        $users = User::select('firstname', 'lastname')
                    ->withSum(['predictions' => function ($query) {
                        $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    }], 'points')
                    ->having('predictions_sum_points', '>', 0)
                    ->orderBy('predictions_sum_points', 'desc')
                    ->get()
                    ->map(function ($user) {
                        return [
                            'firstname' => $user->firstname,
                            'lastname' => $user->lastname,
                            'points' => $user->predictions_sum_points,
                        ];
                    })
                    ->toArray();

        return view('leaderboards.monthly', compact('users'));
    }

    public function recalculate(Competition $competition, Rule $rule, $currentRound)
    {
        $gamesRepository = new Games;
        $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'results', $currentRound);
        $gameIds = $games->pluck('id')->toArray();
        $predictions = Prediction::whereIn('game_id', $gameIds)->get();

        $predictions->each(function ($prediction) {
            $calculatedPoints = $this->calculatePoints($prediction);

            if ($calculatedPoints === null) {
                return;
            }

            $prediction->points = $calculatedPoints;
            $prediction->save();
        });

        return redirect()->back()->with('flash_message_success', '<i class="fas fa-check"></i> Body byly úspěšně přepočítány.');
    }

    private function calculatePoints($prediction): ?int
    {
        if ($prediction->game->getResult() === null) {
            return null;
        }

        if ($prediction->tip === $prediction->game->getResult()) {
            if ($prediction->tip === 'draw' && $prediction->game->getResult() === 'draw') {
                return 2;
            }

            return 1;
        }

        return 0;
    }

}
