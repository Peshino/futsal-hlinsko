<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Seasons;
use App\Season;

class IntroductionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Display an introduction.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasonsRepository = new Seasons;

        $seasons = $seasonsRepository->getSeasons();
        $lastSeason = $seasonsRepository->getLastRecord();

        return view('layouts.introduction', compact('seasons', 'lastSeason'));
    }
}
