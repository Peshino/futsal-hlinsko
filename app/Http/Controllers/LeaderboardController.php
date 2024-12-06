<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Rule;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function global()
    {
        $users = User::withSum('predictions', 'points')
                    ->orderBy('predictions_sum_points', 'desc')
                    ->take(10)
                    ->get();

        return view('leaderboards.index', compact('users'));
    }

    public function weekly()
    {
        $users = User::withSum(['predictions' => function ($query) {
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    }], 'points')
                    ->orderBy('predictions_sum_points', 'desc')
                    ->take(10)
                    ->get();

        return view('leaderboard.global', compact('users'));
    }

    public function monthly()
    {
        $users = User::withSum(['predictions' => function ($query) {
                        $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    }], 'points')
                    ->orderBy('predictions_sum_points', 'desc')
                    ->take(10)
                    ->get();

        return view('leaderboard.global', compact('users'));
    }

    public function recalculate(Competition $competition, $roundId)
    {
        $round = Round::find($roundId);

        if (!$round) {
            return redirect()->back()->with('error', 'Kolo nebylo nalezeno.');
        }

        if ($round->processed) {
            return redirect()->back()->with('error', 'Toto kolo již bylo zpracováno.');
        }

        // Zkontroluj, zda jsou všechny zápasy dokončené
        $allMatchesCompleted = $round->matches()->where('status', '!=', 'completed')->doesntExist();

        if (!$allMatchesCompleted) {
            return redirect()->back()->with('error', 'Některé zápasy v kole nejsou dokončené.');
        }

        // Přepočítej body uživatelů
        $predictions = Prediction::where('round_id', $roundId)->get();
        $usersPoints = [];

        foreach ($predictions as $prediction) {
            $usersPoints[$prediction->user_id] = ($usersPoints[$prediction->user_id] ?? 0) + $prediction->points;
        }

        foreach ($usersPoints as $userId => $points) {
            $user = User::find($userId);

            if ($user) {
                // Přidej body do uživatelského skóre (globální, týdenní, měsíční)
                $user->increment('total_points', $points);
                $user->increment('weekly_points', $points);
                $user->increment('monthly_points', $points);
            }
        }

        // Označ kolo jako zpracované
        $round->update(['processed' => true]);

        return redirect()->back()->with('success', 'Body byly úspěšně přepočítány.');
    }

}
