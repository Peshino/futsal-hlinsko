@extends('layouts.master')

@section('title')
    {{ $competition->name ?? '' }} | {{ $competition->season->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    {{ $competition->name ?? __('messages.homepage') }}
                </div>
            </div>
        </div>

        <div class="card-body no-x-padding">
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

                    {{-- <div class="news">
                        <div class="news-header pb-1 border-bottom border-dark">
                            <h5 class="text-center">
                                Soutěž Hlinsko 2022 / 2023
                            </h5>
                        </div>
                        <div class="news-body">
                            <div class="row">
                                <div class="col-md">
                                    <p>- den 31. 12. 2021 je poslední na dopsání soupisek pro letošní sezónu</p>
                                    <p>- hrát se bude jednokolově každý s každým</p>
                                    <p>- do play-off postoupí prvních 8 týmů</p>
                                    <p>- hrací doba 2 x 16 min</p>
                                    <p>- play-off 2 x 18 min</p>
                                    <p>- semifinále odehraje nejvýše nasazený tým s nejhůře nasazeným</p>
                                </div>
                                <div class="col-md">
                                    <p>- porušení pravidel o očkování nebo testování znamená vyloučení mužstva bez náhrady
                                        startovného
                                    </p>
                                    <p>- podmínkou účasti je očkovaní proti covid-19 nebo potvrzení o prodělání nemoci v
                                        posledních 180 dní</p>
                                    <p>- případné dotazy zasílejte na <a
                                            href="mailto:mates.real@seznam.cz">mates.real@seznam.cz</a> nebo volejte
                                        777&nbsp;201&nbsp;963&nbsp;-&nbsp;Vlastimil Mataj
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- @php
                        $deadline = \Carbon\Carbon::create(2026, 02, 14, 10, 0);
                        $deadline2 = \Carbon\Carbon::create(2026, 02, 14, 16, 0);
                    @endphp

                    @if ($competition->id === 21 && now()->lessThan($deadline))
                        <div class="pt-2 pb-2 pl-4 text-left">
                            <div class="d-inline-flex card-red"></div> &nbsp; STOP NA 1 ZÁPAS: Ondřej Kyncl<br />
                        </div>
                    @endif --}}

                    {{-- @if ($competition->id === 21 && now()->lessThan($deadline2))
                        <div class="pt-2 pb-2 pl-4 text-center">
                            <span class="text-warning">Časy začátků zápasů v Playoff jsou pouze orientační. Hrací doba v play-off je 2 x 10 minut čistého času. Týmy jsou nasazeny podle umístění v základní části.</span>
                        </div>
                    @endif --}}

                    <div class="row mb-4 game">
                        <div class="col no-padding">
                            <div class="pt-2 pb-2 first-place text-center">
                                <h3>
                                    @if ($competition->id === 21)
                                        <a href="{{ route('teams.show', [$competition->id, 224]) }}">
                                            <i class="fas fa-medal"></i> Forza Hlinsko
                                        </a>
                                    @endif

                                    @if ($competition->id === 22)
                                        <a href="{{ route('teams.show', [$competition->id, 225]) }}">
                                            <i class="fas fa-medal"></i> Tatranky
                                        </a>
                                    @endif
                                </h3>
                            </div>
                            <div class="pt-2 pb-2 second-place text-center">
                                <h5>
                                    @if ($competition->id === 21)
                                        <a href="{{ route('teams.show', [$competition->id, 227]) }}">
                                            <i class="fas fa-medal"></i> Tatra tým Hlinsko
                                        </a>
                                    @endif

                                    @if ($competition->id === 22)
                                        <a href="{{ route('teams.show', [$competition->id, 234]) }}">
                                            <i class="fas fa-medal"></i> Předhradí Rychmburk
                                        </a>
                                    @endif
                                </h5>
                            </div>
                            <div class="pt-2 pb-2 third-place text-center">
                                <h5>
                                    @if ($competition->id === 21)
                                        <a href="{{ route('teams.show', [$competition->id, 228]) }}">
                                            <i class="fas fa-medal"></i> Prosetín B
                                        </a>
                                    @endif

                                    @if ($competition->id === 22)
                                        <a href="{{ route('teams.show', [$competition->id, 218]) }}">
                                            <i class="fas fa-medal"></i> Norwich Hlinsko
                                        </a>
                                    @endif
                                </h5>
                            </div>
                            <div class="pt-2 pb-2 text-center">
                                <h5>
                                    Vítězem <span class="game-schedule-color">TIPOVAČKY o 1000 Kč</span> je <span
                                        class="game-score-color">Ondřej Kyncl</span>.
                                </h5>
                            </div>
                        </div>
                    </div>

                    @if ($gameCurrentlyBeingPlayed !== null || $firstSchedule !== null || $lastResult !== null)
                        <div class="justify-content-center border-bottom border-dark mb-2 pb-3">
                            @php
                                $bothGames = false;
                            @endphp

                            @if ($gameCurrentlyBeingPlayed !== null)
                                @php
                                    $game = $gameCurrentlyBeingPlayed;
                                @endphp
                                <div class="row no-margin">
                                    <div class="col no-padding">
                                        @include('partials/game')
                                    </div>
                                </div>
                            @endif

                            @php
                                // $lastResult = null;
                                // $bothGames = $lastResult !== null && $firstSchedule !== null ? true : false;
                                $bothGames = false;
                            @endphp

                            @if ($firstSchedule !== null)
                                @php
                                    $game = $firstSchedule;
                                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                                @endphp
                                <div class="row no-margin">
                                    <div class="col no-padding">
                                        <div class="text-center schedule-color">
                                            @lang('messages.next_schedule') | <small>{{ $startDateTime->isoFormat('Do[.] MMMM') }}</small>
                                        </div>
                                        @include('partials/game')
                                    </div>
                                </div>
                            @endif

                            @if ($lastResult !== null)
                                @php
                                    $game = $lastResult;
                                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                                @endphp
                                <div class="row no-margin">
                                    <div class="col no-padding">
                                        <div class="text-center competition-color">
                                            @lang('messages.last_result') |
                                            <small>{{ $startDateTime->isoFormat('Do[.] MMMM') }}</small>
                                        </div>
                                        @include('partials/game')
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="card-body-x-padding">
                        @if (
                            (isset($goals) && $goals->isNotEmpty()) ||
                                (isset($yellowCards) && $yellowCards->isNotEmpty()) ||
                                (isset($redCards) && $redCards->isNotEmpty()))
                            <h5 class="text-center competition-second-color">
                                @lang('messages.player_statistics')
                            </h5>
                        @endif

                        <div class="my-2 row justify-content-center">
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
                            <div class="my-3 rule-teams">
                                @foreach ($competition->rules as $rule)
                                    @if ($rule->teams->isNotEmpty())
                                        <div class="my-3 border-top border-dark py-2">
                                            <h5 class="text-center competition-second-color">
                                                @lang('messages.teams_playing_the')
                                                <span data-toggle="popover"
                                                    title="@lang('messages.rules') <strong>{{ $rule->name ?? '' }}</strong>"
                                                    data-content="
                                @lang('messages.number_of_rounds') <strong>{{ $rule->number_of_rounds ?? '' }}</strong><br />
                                @lang('messages.system') <strong>@lang('messages.' . $rule->system ?? '' . '')</strong><br />
                                @lang('messages.game_duration') <strong>{{ $rule->game_duration ?? '' }} [@lang('messages.minutes')]</strong><br />
                                @lang('messages.case_of_draw') <strong>@lang('messages.' . $rule->case_of_draw ?? '' . '')</strong><br />
                                @lang('messages.type') <strong>@lang('messages.' . $rule->type ?? '' . '')</strong><br />
                                <strong>{{ $rule->isAppliedMutualBalance() ? __('messages.mutual_balance_applied') : __('messages.mutual_balance_not_applied') }}</strong><br />
                                ">
                                                    <span class="anchor">{{ $rule->name ?? '' }}</span>
                                                </span>
                                            </h5>

                                            <div class="mx-3">
                                                <div class="row d-flex justify-content-center">
                                                    @foreach ($rule->teams as $team)
                                                        @php
                                                            if (
                                                                $team?->primary_color_id !== null &&
                                                                $team?->secondary_color_id === null
                                                            ) {
                                                                $style =
                                                                    'border-left: 5px solid ' .
                                                                    $team->primaryColor->hex_code .
                                                                    ' ; background: linear-gradient(to right, rgba(13,22,37,1) 0%, rgba(' .
                                                                    $team->primaryColor->rgb_code .
                                                                    ',0.65) 100%)';
                                                            } elseif (
                                                                $team?->primary_color_id !== null &&
                                                                $team?->secondary_color_id !== null
                                                            ) {
                                                                $style =
                                                                    'border-left: 5px solid ' .
                                                                    $team?->secondaryColor->hex_code .
                                                                    ' ; background: linear-gradient(to right, rgba(13,22,37,1) 0%, rgba(' .
                                                                    $team?->primaryColor->rgb_code .
                                                                    ',0.65) 100%)';
                                                            } else {
                                                                $style = '';
                                                            }
                                                        @endphp
                                                        <a href="{{ route('teams.show', [$competition->id, $team->id]) }}"
                                                            class="col-12 col-sm-5 col-md-5 col-lg-5 col-xl-23percent py-3 m-2 bg-dark rounded"
                                                            style="{{ $style }}">
                                                            {{ $team->name ?? '' }} <br />
                                                            <span class="text-secondary">{{ $team->name_short }}</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{-- @foreach ($rule->teams as $team)
                                            <div class="d-inline-flex flex-wrap">
                                                <a href="{{ route('teams.show', [$competition->id, $team->id]) }}"
                                                    class="px-4 py-25 m-1">
                                                    <div class="team-name-long">
                                                        {{ $team->name }}
                                                    </div>
                                                    <div class="team-name-short" title="{{ $team->name }}">
                                                        {{ $team->name_short }}
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach --}}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
