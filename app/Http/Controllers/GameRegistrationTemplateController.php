<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Competition;
use App\Repositories\Games;

class GameRegistrationTemplateController extends Controller
{
    public function index(Competition $competition)
    {
        // + navýšen memory_limit v php.ini
        set_time_limit(3000);
        $gamesRepository = new Games;
        $games = $gamesRepository->getGamesFiltered($competition, null, null, 'schedule');

        $pdf = Pdf::loadView('game-registration-template', [
            'games' => $games,
            'competition' => $competition,
        ]);

        // return view('game-registration-template', compact('games', 'competition'));
        // return $pdf->stream('zapasovy-zapis.pdf');
        return $pdf->download('zapasovy-zapis.pdf');
    }

}
