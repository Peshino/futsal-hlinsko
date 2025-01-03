<?php

namespace App\Http\Controllers;

use App\Competition;
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

    public function recalculate(Competition $competition, $gameIds)
    {
        $gamesRepository = new Games;
        $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'results', $currentRound);
        $predictions = Prediction::whereIn('game_id', $games->pluck('id'))->get();
        $usersPoints = [];

        foreach ($predictions as $prediction) {
            $usersPoints[$prediction->user_id] = ($usersPoints[$prediction->user_id] ?? 0) + $prediction->points;
        }

        dd($usersPoints);

        return redirect()->back()->with('success', 'Body byly úspěšně přepočítány.');
    }

}
