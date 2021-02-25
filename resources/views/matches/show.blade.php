@extends('layouts.master')

@section('title')
{{ $match->homeTeam->name_short }} {{ $match->home_team_score }}:{{ $match->away_team_score }}
{{ $match->awayTeam->name_short }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.match')
            </div>

            @can('crud_matches')
            <div class="col">
                <ul class="list-inline justify-content-end">
                    <li class="list-inline-item">
                        <a class="crud-button" href="{{ route('matches.edit', [$competition->id, $match->id]) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <form method="POST" action="{{ route('matches.destroy', [$competition->id, $match->id]) }}"
                            autocomplete="off">
                            @csrf
                            @method('DELETE')
                            <button class="crud-button" type="button" data-toggle="modal"
                                data-target="#modal-match-delete"><i class="far fa-trash-alt"></i></button>

                            <div class="modal fade" id="modal-match-delete" tabindex="-1" role="dialog"
                                aria-labelledby="modal-match-delete-title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-match-delete-title">
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
                <div class="pt-4 pb-3 match">
                    <div class="text-center">
                        <h3>
                            @lang('messages.' . $match->rule->name ?? '' . '') - {{ $match->round ?? '' }}.
                            @lang('messages.round')
                        </h3>
                    </div>
                    <div class="mt-4 text-center">
                        <h5>
                            @php
                            $startDateTime = \Carbon\Carbon::parse($match->start_datetime);
                            echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm');
                            @endphp
                        </h5>
                    </div>
                    <div class="mt-4 row">
                        <div class="match-team col-4 d-flex flex-row-reverse">
                            <span class="justify-content-center align-self-center">
                                <div class="team-name-long">
                                    <span class="align-middle">
                                        <a href="{{ route('teams.show', [$competition->id, $match->homeTeam->id]) }}">
                                            {{ $match->homeTeam->name }}
                                        </a>
                                    </span>
                                </div>
                                <div class="team-name-short">
                                    <span class="align-middle">
                                        <a href="{{ route('teams.show', [$competition->id, $match->homeTeam->id]) }}">
                                            {{ $match->homeTeam->name_short }}
                                        </a>
                                    </span>
                                </div>
                            </span>
                        </div>
                        <div class="match-score col-4 text-center">
                            <span class="justify-content-center align-self-center">
                                <div class="row">
                                    <div class="col-6 match-score-home d-flex flex-row-reverse">
                                        {{ $match->home_team_score }}
                                    </div>
                                    <div class="col-6 match-score-away d-flex">
                                        {{ $match->away_team_score }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 match-halftime-score-home d-flex flex-row-reverse">
                                        {{ $match->home_team_halftime_score }}
                                    </div>
                                    <div class="col-6 match-halftime-score-away d-flex">
                                        {{ $match->away_team_halftime_score }}
                                    </div>
                                </div>
                            </span>
                        </div>
                        <div class="match-team col-4 d-flex">
                            <span class="justify-content-center align-self-center">
                                <div class="team-name-long">
                                    <span class="align-middle">
                                        <a href="{{ route('teams.show', [$competition->id, $match->awayTeam->id]) }}">
                                            {{ $match->awayTeam->name }}
                                        </a>
                                    </span>
                                </div>
                                <div class="team-name-short">
                                    <span class="align-middle">
                                        <a href="{{ route('teams.show', [$competition->id, $match->awayTeam->id]) }}">
                                            {{ $match->awayTeam->name_short }}
                                        </a>
                                    </span>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="shooters">
                    <div class="row">
                        <div class="col shooters-home">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="balls text-right pr-3">
                                            4 x <i class="far fa-futbol"></i>
                                        </td>
                                        <td>
                                            Mášík Drahoš
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="balls text-right pr-3">
                                            2 x <i class="far fa-futbol"></i>
                                        </td>
                                        <td>
                                            Jiří Pešek
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="balls text-right pr-3">
                                            <i class="far fa-futbol"></i>
                                        </td>
                                        <td>
                                            Pavel Adámek, Michal Šally
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col shooters-away">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="balls text-right pr-3">
                                            2 x <i class="far fa-futbol"></i>
                                        </td>
                                        <td>
                                            Franta Vopršálek
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection