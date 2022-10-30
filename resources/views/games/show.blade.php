@extends('layouts.master')

@section('title')
    {{ $game->homeTeam->name_short }} {{ $game->home_team_score }}:{{ $game->away_team_score }}
    {{ $game->awayTeam->name_short }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.game')
                </div>

                @can('crud_games')
                    <div class="col">
                        <ul class="list-inline justify-content-end">
                            <li class="list-inline-item">
                                <a class="crud-button" href="{{ route('games.edit', [$competition->id, $game->id]) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <form method="POST" action="{{ route('games.destroy', [$competition->id, $game->id]) }}"
                                    autocomplete="off">
                                    @csrf
                                    @method('DELETE')

                                    @include('partials/modals.delete')
                                </form>
                            </li>
                        </ul>
                    </div>
                @endcan
            </div>
        </div>

        <div class="card-body p-0">
            <div class="content">
                <div class="content-block">
                    <div class="pt-4 pb-3 game">
                        <div class="text-center">
                            <h3>
                                {{ $game->rule->name ?? '' }} - {{ $game->round ?? '' }}.
                                @lang('messages.round')
                            </h3>
                        </div>
                        <div class="mt-4 text-center">
                            <h5>
                                @php
                                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                                    $startTime = $startDateTime->toTimeString();
                                @endphp

                                @if ($startTime === '00:00:00')
                                    {{ $startDateTime->isoFormat('dddd[,] Do[.] MMMM') }}
                                @else
                                    {{ $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm') }}
                                @endif
                            </h5>
                        </div>
                        <div class="mt-4 row">
                            <div class="game-team col-4 d-flex flex-row-reverse">
                                <span class="justify-content-center align-self-center">
                                    <div class="team-name-long">
                                        <span class="align-middle">
                                            <a href="{{ route('teams.show', [$competition->id, $game->homeTeam->id]) }}">
                                                {{ $game->homeTeam->name }}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="team-name-short">
                                        <span class="align-middle">
                                            <a href="{{ route('teams.show', [$competition->id, $game->homeTeam->id]) }}"
                                                title="{{ $game->homeTeam->name }}">
                                                {{ $game->homeTeam->name_short }}
                                            </a>
                                        </span>
                                    </div>
                                </span>
                            </div>
                            @if ($game->hasScore())
                                <div class="game-score col-4 text-center">
                                    <span class="justify-content-center align-self-center">
                                        <div class="row">
                                            <div class="col-6 game-score-home d-flex flex-row-reverse">
                                                {{ $game->home_team_score }}
                                            </div>
                                            <div class="col-6 game-score-away d-flex">
                                                {{ $game->away_team_score }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 game-halftime-score-home d-flex flex-row-reverse">
                                                {{ $game->home_team_halftime_score }}
                                            </div>
                                            <div class="col-6 game-halftime-score-away d-flex">
                                                {{ $game->away_team_halftime_score }}
                                            </div>
                                        </div>
                                    </span>
                                </div>
                            @else
                                <div class="game-schedule col-4 text-center">
                                    <span class="justify-content-center align-self-center">
                                        vs
                                    </span>
                                </div>
                            @endif
                            <div class="game-team col-4 d-flex">
                                <span class="justify-content-center align-self-center">
                                    <div class="team-name-long">
                                        <span class="align-middle">
                                            <a href="{{ route('teams.show', [$competition->id, $game->awayTeam->id]) }}">
                                                {{ $game->awayTeam->name }}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="team-name-short">
                                        <span class="align-middle">
                                            <a href="{{ route('teams.show', [$competition->id, $game->awayTeam->id]) }}"
                                                title="{{ $game->awayTeam->name }}">
                                                {{ $game->awayTeam->name_short }}
                                            </a>
                                        </span>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row goals-cards">
                        <div class="col p-3">
                            <div class="row">
                                <div class="col-md goals-home mb-2">
                                    <div class="row">
                                        @if ($homeTeamGoals->isNotEmpty())
                                            @foreach ($homeTeamGoals as $homeTeamGoal)
                                                <div class="col-4 text-right">
                                                    {{ $homeTeamGoal->amount > 1 ? $homeTeamGoal->amount . ' x' : '' }} <i
                                                        class="far fa-futbol"></i>
                                                </div>
                                                <div class="col-8 text-left">
                                                    <a
                                                        href="{{ route('players.show', [$competition->id, $game->homeTeam->id, $homeTeamGoal->player->id]) }}">
                                                        {{ mb_convert_case($homeTeamGoal->player->firstname, MB_CASE_TITLE, 'UTF-8') }}
                                                        {{ mb_convert_case($homeTeamGoal->player->lastname, MB_CASE_TITLE, 'UTF-8') }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md cards-home">
                                    <div class="row">
                                        @if ($homeTeamCards->isNotEmpty())
                                            @foreach ($homeTeamCards as $homeTeamCard)
                                                <div class="col-4 text-right">
                                                    {{-- tento způsob výpisu není bezpečný {!! !!} --}}
                                                    {!! $homeTeamCard->yellow > 0 ? '<div class="d-inline-flex card-yellow"></div>' : '' !!}
                                                    {!! $homeTeamCard->red > 0 ? '<div class="d-inline-flex card-red"></div>' : '' !!}
                                                </div>
                                                <div class="col-8 text-left">
                                                    <a
                                                        href="{{ route('players.show', [$competition->id, $game->homeTeam->id, $homeTeamCard->player->id]) }}">
                                                        {{ mb_convert_case($homeTeamCard->player->firstname, MB_CASE_TITLE, 'UTF-8') }}
                                                        {{ mb_convert_case($homeTeamCard->player->lastname, MB_CASE_TITLE, 'UTF-8') }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col p-3">
                            <div class="row">
                                <div class="col-md goals-away mb-2">
                                    <div class="row">
                                        @if ($awayTeamGoals->isNotEmpty())
                                            @foreach ($awayTeamGoals as $awayTeamGoal)
                                                <div class="col-4 text-right">
                                                    {{ $awayTeamGoal->amount > 1 ? $awayTeamGoal->amount . ' x' : '' }} <i
                                                        class="far fa-futbol"></i>
                                                </div>
                                                <div class="col-8 text-left">
                                                    <a
                                                        href="{{ route('players.show', [$competition->id, $game->awayTeam->id, $awayTeamGoal->player->id]) }}">
                                                        {{ mb_convert_case($awayTeamGoal->player->firstname, MB_CASE_TITLE, 'UTF-8') }}
                                                        {{ mb_convert_case($awayTeamGoal->player->lastname, MB_CASE_TITLE, 'UTF-8') }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md cards-away">
                                    <div class="row">
                                        @if ($awayTeamCards->isNotEmpty())
                                            @foreach ($awayTeamCards as $awayTeamCard)
                                                <div class="col-4 text-right">
                                                    {{-- tento způsob výpisu není bezpečný {!! !!} --}}
                                                    {!! $awayTeamCard->yellow > 0 ? '<div class="d-inline-flex card-yellow"></div>' : '' !!}
                                                    {!! $awayTeamCard->red > 0 ? '<div class="d-inline-flex card-red"></div>' : '' !!}
                                                </div>
                                                <div class="col-8 text-left">
                                                    <a
                                                        href="{{ route('players.show', [$competition->id, $game->awayTeam->id, $awayTeamCard->player->id]) }}">
                                                        {{ mb_convert_case($awayTeamCard->player->firstname, MB_CASE_TITLE, 'UTF-8') }}
                                                        {{ mb_convert_case($awayTeamCard->player->lastname, MB_CASE_TITLE, 'UTF-8') }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
