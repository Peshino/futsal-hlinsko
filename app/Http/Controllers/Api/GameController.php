<?php

namespace App\Http\Controllers\Api;

use App\Competition;
use App\Rule;
use App\Http\Controllers\Controller;
use App\Services\GameService;

class GameController extends Controller
{
    /**
     * Get a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  mixed $toRound
     * @return \Illuminate\Http\Response
     */
    public function getTableDataJson(Competition $competition, Rule $rule, $toRound = null)
    {
        $tableData = (new GameService())->getTableData($competition, $rule, $toRound, true);

        $tableDataCollection = collect($tableData);

        $tableDataJson = $tableDataCollection->toJson();

        return $tableDataJson;
    }
}
