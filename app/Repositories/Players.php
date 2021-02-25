<?php

namespace App\Repositories;

use App\Player;

class Players
{
    public function __construct()
    {
    }

    public function all()
    {
        return Player::all();
    }

    public function getPlayers()
    {
        return Player::orderBy('lastname', 'desc')->orderBy('firstname', 'desc')->get();
    }
}
