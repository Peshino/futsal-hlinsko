@extends('layouts.master')

@section('title')
{{ $game->homeTeam->name_short }} {{ $game->home_team_score }}:{{ $game->away_team_score }}
{{ $game->awayTeam->name_short }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
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
                            <button class="crud-button" type="button" data-toggle="modal"
                                data-target="#modal-game-delete"><i class="far fa-trash-alt"></i></button>

                            <div class="modal fade" id="modal-game-delete" tabindex="-1" role="dialog"
                                aria-labelledby="modal-game-delete-title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-game-delete-title">
                                                @lang('messages.really_delete')
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                @lang('messages.delete')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body no-padding">
        <div class="content">
            <div class="content-block">
                <div class="pt-4 pb-3 game">
                    <div class="text-center">
                        <h3>
                            @lang('messages.' . $game->rule->name ?? '' . '') - {{ $game->round ?? '' }}.
                            @lang('messages.round')
                        </h3>
                    </div>
                    <div class="mt-4 text-center">
                        <h5>
                            @php
                            $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                            echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm');
                            @endphp
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
                                        <a href="{{ route('teams.show', [$competition->id, $game->homeTeam->id]) }}">
                                            {{ $game->homeTeam->name_short }}
                                        </a>
                                    </span>
                                </div>
                            </span>
                        </div>
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
                                        <a href="{{ route('teams.show', [$competition->id, $game->awayTeam->id]) }}">
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
                                    @if (count($homeTeamGoals) > 0)
                                    @foreach ($homeTeamGoals as $homeTeamGoal)
                                    <div class="col-4 text-right">
                                        {{ $homeTeamGoal->amount > 1 ? $homeTeamGoal->amount . ' x' : '' }} <i
                                            class="far fa-futbol"></i>
                                    </div>
                                    <div class="col-8 text-left">
                                        <a
                                            href="{{ route('players.show', [$competition->id, $game->homeTeam->id, $homeTeamGoal->player->id]) }}">
                                            {{ $homeTeamGoal->player->lastname }} {{ $homeTeamGoal->player->firstname }}
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md cards-home">
                                <div class="row">
                                    <div class="col-4 text-right">
                                        ŽK
                                    </div>
                                    <div class="col-8 text-left">
                                        Jiří Pešek
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col p-3">
                        <div class="row">
                            <div class="col-md goals-away mb-2">
                                <div class="row">
                                    @if (count($awayTeamGoals) > 0)
                                    @foreach ($awayTeamGoals as $awayTeamGoal)
                                    <div class="col-4 text-right">
                                        {{ $awayTeamGoal->amount > 1 ? $awayTeamGoal->amount . ' x' : '' }} <i
                                            class="far fa-futbol"></i>
                                    </div>
                                    <div class="col-8 text-left">
                                        <a
                                            href="{{ route('players.show', [$competition->id, $game->awayTeam->id, $awayTeamGoal->player->id]) }}">
                                            {{ $awayTeamGoal->player->firstname }} {{ $awayTeamGoal->player->lastname }}
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md cards-away">
                                <div class="row">
                                    <div class="col-4 text-right">
                                        ŽK
                                    </div>
                                    <div class="col-8 text-left">
                                        Jiří Pešek
                                    </div>
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