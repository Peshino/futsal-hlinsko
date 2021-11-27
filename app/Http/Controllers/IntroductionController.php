<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Seasons;
use Illuminate\Support\Facades\DB;


class IntroductionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest');

        // $cards = DB::connection('mysql2')->select('SELECT * FROM `cards`');

        // $seedFromOldDb = true;

        // dd('database/data/' . ($seedFromOldDb ? 'oldDB/' : '') . 'seasons.json');
    }

    /**
     * Display an introduction.
     *
     * @param  \App\Repositories\Seasons  $seasonsRepository
     * @return \Illuminate\Http\Response
     */
    public function index(Seasons $seasonsRepository)
    {
        $seasons = $seasonsRepository->getSeasons();
        $lastSeason = $seasonsRepository->getLastRecord();

        return view('layouts.introduction', compact('seasons', 'lastSeason'));
    }
}
