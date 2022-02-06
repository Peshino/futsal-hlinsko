@extends('layouts.master')

@section('title')
{{ $competition->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                {{ $competition->name ?? __('messages.homepage') }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                {{-- <h3>Zde na homepage soutěže by mohlo být:</h3>
                <ul class="pl-5">
                    <li>důležitá upozornění od administrátora, novinky přidané do aplikace</li>
                    <ul class="pl-5">
                        <li>toto by mohlo být komentovatelné a likovatelné přihlášenými osobami, případně vytvořit
                            možnost přihlášení skrze facebook?</li>
                        <li>cílem je aplikaci více socializovat, udělat věci, které by zde registrovaní mohli dělat -
                            větší návštěvnost a sledovanost</li>
                    </ul>
                    <li>seznam týmů</li>
                    <li>první tým postupové skupiny, první tým sestupové skupiny (případně aktuálně postupující a
                        aktuálně sestupující tým)</li>
                    <li>poslední a nadcházející zápasy (hodnocení atraktivity zápasů?)</li>
                    <li>statistiky - nejlepší střelec soutěže, nejvíc žlutých, nejvíc červených karet (+ 3 další)</li>
                    <li>gólů celkem v soutěži, průměr gólů na zápas, nejvíce gólový zápas</li>
                    <li>část tabulky nebo playoff</li>
                    <li>základní informace o soutěži (systém, sezona, atd.)</li>
                </ul> --}}

                <div class="news">
                    <div class="news-header pb-1 border-bottom border-dark">
                        <h4>
                            Soutěž Hlinsko 2021 / 2022
                        </h4>
                    </div>
                    {{-- <div class="news-body">

                    </div> --}}
                </div>
                <div class="row mb-4 game">
                    <div class="col no-padding">
                        <div class="pt-2 pb-2 first-place text-center">
                            <h3>
                                <a href="{{ route('teams.show', [$competition->id, 142]) }}">
                                    <i class="fas fa-medal"></i> Bison Steak Hlinsko
                                </a>
                            </h3>
                        </div>
                        <div class="pt-2 pb-2 second-place text-center">
                            <h4>
                                <a href="{{ route('teams.show', [$competition->id, 154]) }}">
                                    <i class="fas fa-medal"></i> Srníčko
                                </a>
                            </h4>
                        </div>
                        <div class="pt-2 pb-2 third-place text-center">
                            <h5>
                                <a href="{{ route('teams.show', [$competition->id, 147]) }}">
                                    <i class="fas fa-medal"></i> Hattrick Svratka
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>

                @php
                $bothGames = false;
                @endphp

                @if ($gameCurrentlyBeingPlayed !== null)
                @php
                $game = $gameCurrentlyBeingPlayed;
                @endphp
                <div class="row">
                    <div class="col no-padding">
                        @include('partials/game')
                    </div>
                </div>
                @endif

                @php
                // $lastResult = null;
                $bothGames = ($lastResult !== null && $firstSchedule !== null) ? true : false;
                @endphp

                <div class="{{ $bothGames ? 'my-4 row ' : '' }}justify-content-center">
                    @if ($lastResult !== null)
                    @php
                    $game = $lastResult;
                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                    @endphp
                    <div class="col-md no-padding">
                        <div class="text-center competition-color">
                            @lang('messages.last_result') | <small>{{ $startDateTime->isoFormat('Do[.] MMMM') }}</small>
                        </div>
                        @include('partials/game')
                    </div>
                    @endif

                    @if ($firstSchedule !== null)
                    @php
                    $game = $firstSchedule;
                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                    @endphp
                    <div class="col-md no-padding">
                        <div class="text-center schedule-color">
                            @lang('messages.next_schedule') | <small>{{ $startDateTime->isoFormat('Do[.] MMMM')
                                }}</small>
                        </div>
                        @include('partials/game')
                    </div>
                    @endif
                </div>

                <div class="my-4 row justify-content-center">
                    @if (isset($goals) && $goals->isNotEmpty())
                    <div class="col-lg-4">
                        @include('partials/goals.selection')
                    </div>
                    @endif

                    @if (isset($yellowCards) && $yellowCards->isNotEmpty())
                    <div class="col-lg-4">
                        @include('partials/cards.yellow-selection')
                    </div>
                    @endif

                    @if (isset($redCards) && $redCards->isNotEmpty())
                    <div class="col-lg-4">
                        @include('partials/cards.red-selection')
                    </div>
                    @endif
                </div>

                @if ($competition->rules->isNotEmpty())
                <div class="my-3 rule-teams text-center">
                    @foreach ($competition->rules as $rule)
                    @if ($rule->teams->isNotEmpty())
                    <div class="my-3 border-top border-dark py-2">
                        <h4>
                            <span data-toggle="popover"
                                title="@lang('messages.rules') <strong>{{ $rule->name ?? ''}}</strong>" data-content="
                                @lang('messages.number_of_rounds') <strong>{{ $rule->number_of_rounds ?? '' }}</strong><br />
                                @lang('messages.system') <strong>@lang('messages.' . $rule->system ?? '' . '')</strong><br />
                                @lang('messages.game_duration') <strong>{{ $rule->game_duration ?? '' }} [@lang('messages.minutes')]</strong><br />
                                @lang('messages.case_of_draw') <strong>@lang('messages.' . $rule->case_of_draw ?? '' . '')</strong><br />
                                @lang('messages.type') <strong>@lang('messages.' . $rule->type ?? '' . '')</strong><br />
                                <strong>{{ $rule->isAppliedMutualBalance() ? __('messages.mutual_balance_applied') : __('messages.mutual_balance_not_applied') }}</strong><br />
                                ">
                                <i class="fas fa-info-circle text-info"></i>&nbsp;&nbsp;{{ $rule->name ?? '' }}
                            </span>
                        </h4>
                        @foreach ($rule->teams as $team)
                        <div class="d-inline-flex flex-wrap">
                            <a href="{{ route('teams.show', [$competition->id, $team->id]) }}" class="px-4 py-25 m-1">
                                <div class="team-name-long">
                                    {{ $team->name }}
                                </div>
                                <div class="team-name-short" title="{{ $team->name }}">
                                    {{ $team->name_short }}
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection