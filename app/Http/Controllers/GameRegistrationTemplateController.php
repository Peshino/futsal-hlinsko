<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Competition;
use App\Rule;
use App\Repositories\Games;

class GameRegistrationTemplateController extends Controller
{
    public function index(Competition $competition, Rule $rule = null)
    {
        // + navýšen memory_limit v php.ini
        set_time_limit(3000);
        $gamesRepository = new Games;
        $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule');
        $brackets = $rule !== null && $rule->type === 'brackets' ? $rule->getBrackets() : [];
        $gamesInBrackets = [];

        if ($rule !== null) {
            $teams = $rule->teams;
            $teamsCount = count($teams);

            // TODO: udělat teoretické dvojice pomocí kombinatoriky
            // V případě, že bude dvojic hodně (např. více jak 20), což už se tolik nevyplatí tisknout, pak udělat prázdné zápisy (bez týmů a hráčů)
            $thirdPlacePossibleTeamPairs = [
                // 0 => [177, 191],
                // 1 => [177, 183],
                // 2 => [191, 185],
                // 3 => [183, 185],
            ];
            $finalPossibleTeamPairs = [
                // 0 => [183, 185],
                // 1 => [191, 185],
                // 2 => [177, 183],
                // 3 => [177, 191],
            ];

            if (!empty($brackets)) {
                foreach ($brackets as $stage => $bracket) {
                    foreach ($bracket as $game) {
                        // TODO: vyřešit následující 2 případy

                        // pro případ čtvrtfinále - moc kombinací do dalších kol
                        // $game->stage = $stage;
                        // $gamesInBrackets[] = $game;

                        // pro případ semifinále a další kola
                        if ($game->home_team_id !== null && $game->away_team_id !== null) {
                            $game->stage = $stage;
                            $gamesInBrackets[] = $game;
                        } else {
                            if ($stage === 'third_place_game') {
                                $pairs = $thirdPlacePossibleTeamPairs;
                            } elseif ($stage === 'final') {
                                $pairs = $finalPossibleTeamPairs;
                            }

                            foreach ($pairs ?? [] as $pair) {
                                $clonedGame = clone $game;
                                $clonedGame->stage = $stage;
                                $clonedGame->home_team_id = $pair[0];
                                $clonedGame->away_team_id = $pair[1];
                                $gamesInBrackets[] = $clonedGame;
                            }
                        }
                    }
                }

                $games = $gamesInBrackets;
            }
        }

        $pdf = Pdf::loadView('game-registration-template', [
            'games' => $games,
            'competition' => $competition,
        ]);

        // return view('game-registration-template', compact('games', 'competition'));
        // return $pdf->stream('zapasovy-zapis.pdf');
        return $pdf->download('zapasovy-zapis.pdf');
    }
}
