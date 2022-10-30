@extends('layouts.master')

@section('title')
    @lang('messages.cards') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
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
                                        @if ($rule === null)
                                            @lang('messages.rules')
                                        @else
                                            {{ $rule->name ?? '' }}
                                        @endif
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('cards.index', [$competition->id]) }}">
                                            @lang('messages.all')
                                        </a>
                                        @foreach ($competition->rules as $competitionRule)
                                            <a class="dropdown-item{{ $rule !== null && $competitionRule->id === $rule->id
                                                ? "
                                                                                active"
                                                : '' }}"
                                                href="{{ route('cards.rule-index', [$competition->id, $competitionRule->id, null]) }}">
                                                {{ $competitionRule->name ?? '' }}
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
                                            href="{{ route('cards.' . ($rule !== null ? 'rule-' : '') . 'index', [$competition->id, $rule !== null ? $rule->id : 'all', null]) }}">
                                            @lang('messages.all')
                                        </a>
                                        @foreach ($cardsTeams as $cardsTeam)
                                            <a class="dropdown-item{{ $team !== null && $cardsTeam->id === $team->id ? ' active' : '' }}"
                                                href="{{ route('cards.team-index', [$competition->id, $rule !== null ? $rule->id : 'all', $cardsTeam->id]) }}">
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
                    <div class="row">
                        <div class="col-md">
                            @php
                                $cards = $yellowCards;
                                $cardType = 'yellow';
                            @endphp
                            @include('partials/cards.table')
                        </div>

                        <div class="col-md">
                            @php
                                $cards = $redCards;
                                $cardType = 'red';
                            @endphp
                            @include('partials/cards.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
