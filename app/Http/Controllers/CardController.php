<?php

namespace App\Http\Controllers;

use App\Team;
use App\Card;
use App\Rule;
use App\Competition;
use App\Repositories\Cards;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:crud_cards')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition, Rule $rule = null, Team $team = null)
    {
        $cardsRepository = new Cards;
        $rule = $rule === null ? $competition->getLastRuleByPriority() : $rule;

        if ($rule !== null) {
            $cards = $cardsRepository->getSummedCardsFiltered($competition, $rule);
            $cardsTeams = Team::whereIn('id', $cards->unique('team_id')->pluck('team_id')->toArray())->orderBy('name')->get();

            if ($team !== null) {
                $cards = $cardsRepository->getSummedCardsFiltered($competition, $rule, null, $team);
            }

            return view('cards.index', compact('competition', 'cards', 'rule', 'cardsTeams', 'team'));
        } else {
            return redirect()->route('rules.create', ['competition' => $competition->id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}
