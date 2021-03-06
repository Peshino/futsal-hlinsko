@extends('layouts.master')

@section('title')
@lang('messages.cards') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.cards')
            </div>

            <div class="col-8 col-right d-flex flex-row-reverse">
                <div class="row">
                    @if (count($competition->rules) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @lang('messages.' . $rule->name ?? '' . '')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{-- <a class="dropdown-item" href="">
                            @lang('messages.all')
                        </a> --}}
                                @foreach ($competition->rules as $competitionRule)
                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? " active" : "" }}"
                                    href="{{ route('cards.rule-index', [$competition->id, $competitionRule->id, null]) }}">
                                    @lang('messages.' . $competitionRule->name ?? '' . '')
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (count($cardsTeams) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @if ($team === null)
                                @lang('messages.teams')
                                @else
                                {{ $team->name_short ?? '' }}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"
                                    href="{{ route('cards.rule-index', [$competition->id, $rule->id, null]) }}">
                                    @lang('messages.all')
                                </a>
                                @foreach ($cardsTeams as $cardsTeam)
                                <a class="dropdown-item{{ ($team !== null && $cardsTeam->id === $team->id) ? " active" : "" }}"
                                    href="{{ route('cards.team-index', [$competition->id, $rule->id, $cardsTeam->id]) }}">
                                    {{ $cardsTeam->name ?? '' }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block container">
                @if (count($cards) > 0)
                <div class="list-group">
                    <table class="table table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-left">@lang('messages.player')</th>
                                <th scope="col" class="text-left">@lang('messages.team')</th>
                                <th scope="col">
                                    <div class="d-inline-flex card-yellow"></div>
                                </th>
                                <th scope="col">
                                    <div class="d-inline-flex card-red"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cards as $key => $card)
                            @php
                            $key += 1;
                            @endphp
                            <tr>
                                <td>
                                    {{ $key ?? '' }}
                                </td>
                                <td class="text-left">
                                    <a
                                        href="{{ route('players.show', [$competition->id, $card->team->id, $card->player->id]) }}">
                                        {{ $card->player->lastname }} {{ $card->player->firstname }}
                                    </a>
                                    <small>- @lang('messages.' . $card->player->position)</small>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('teams.show', [$competition->id, $card->team->id]) }}">
                                        {{ $card->team->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $card->yellow }}
                                </td>
                                <td>
                                    {{ $card->red }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                -----
                @endif
            </div>
        </div>
    </div>
</div>
@endsection