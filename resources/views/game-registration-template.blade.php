<!doctype html>
<html lang="cs">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zápisy</title>

    <link rel="stylesheet" href="{{ asset('css/game-registration-template.blade.css') }}" type="text/css">
</head>

<body>
    @if ($games->isNotEmpty())
        @php
            $gameDateStrings = [];
            $gameNumberInRound = 1;
        @endphp

        @foreach ($games as $game)
            @php
                $gameDateString = \Carbon\Carbon::parse($game->start_datetime)->isoFormat('dddd[,] Do[.] M[.] YYYY');
            @endphp

            @if (!in_array($gameDateString, $gameDateStrings))
                @php
                    $gameDateStrings[] = $gameDateString;
                    $gameNumberInRound = 1;
                @endphp
            @else
                @php
                    $gameNumberInRound += 1;
                @endphp
            @endif


            {{-- TODO: delete when dev finished --}}
            @if ($loop->iteration === 6)
            @break
        @endif


        <div class="header">
            <div class="game-round lowercase">
                <p>
                    {{ $game->rule->name ?? 'soutěž' }} | {{ $game->round ?? '' }}. @lang('messages.round') |
                    {{ $gameNumberInRound }}. @lang('messages.game')
                </p>
            </div>
            <div class="season">
                <p>
                    {{ $competition->name ?? '' }} | {{ $competition->season->name_short ?? '' }} |
                    @lang('messages.app_name')
                </p>
            </div>

            <div style="clear: both;"></div>
        </div>

        <h1>
            ZÁPIS
        </h1>

        <h2>
            {{ $gameDateString }}
        </h2>

        <div class="team-names">
            <div class="team-box">
                <p>
                    {{ $game->homeTeam->name }}
                </p>
            </div>
            <div class="team-box">
                <p>
                    {{ $game->awayTeam->name }}
                </p>
            </div>

            <div style="clear: both;"></div>
        </div>

        <p class="score">
            ____________ : ____________
        </p>
        <p class="half-time-score">
            (_________ : _________)
        </p>

        <div class="team-tables">
            @php
                $maxRowsCount = 26;
                $maxTeamPlayersCount = $maxRowsCount - 3;
                $homeTeamTableEmptyRowsCount = $maxRowsCount - count($game->homeTeam->players);
                $awayTeamTableEmptyRowsCount = $maxRowsCount - count($game->awayTeam->players);
            @endphp

            <table class="team-table">
                <tr>
                    <th>číslo</th>
                    <th>jméno</th>
                    <th>branky</th>
                    <th>ŽK</th>
                    <th>ČK</th>
                </tr>
                @if ($game->homeTeam->players->isNotEmpty() && count($game->homeTeam->players) <= $maxTeamPlayersCount)
                    @foreach ($game->homeTeam->players as $player)
                        <tr>
                            <td>
                                {!! $loop->iteration <= $maxTeamPlayersCount ? $player->jersey_number ?? '' : '&nbsp;' !!}
                            </td>
                            <td>
                                @if ($loop->iteration <= $maxTeamPlayersCount)
                                    <span class="uppercase">
                                        {{ $player->lastname }}
                                    </span>
                                    {{ $player->firstname }}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    @endforeach
                @else
                    @php
                        $homeTeamTableEmptyRowsCount = $maxRowsCount;
                    @endphp
                @endif
                @for ($i = 1; $i <= $homeTeamTableEmptyRowsCount; $i++)
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                @endfor
            </table>

            <table class="team-table">
                <tr>
                    <th>číslo</th>
                    <th>jméno</th>
                    <th>branky</th>
                    <th>ŽK</th>
                    <th>ČK</th>
                </tr>
                @if ($game->awayTeam->players->isNotEmpty() && count($game->awayTeam->players) <= $maxTeamPlayersCount)
                    @foreach ($game->awayTeam->players as $player)
                        <tr>
                            <td>
                                {!! $loop->iteration <= $maxTeamPlayersCount ? $player->jersey_number ?? '' : '&nbsp;' !!}
                            </td>
                            <td>
                                @if ($loop->iteration <= $maxTeamPlayersCount)
                                    <span class="uppercase">
                                        {{ $player->lastname }}
                                    </span>
                                    {{ $player->firstname }}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    @endforeach
                @else
                    @php
                        $awayTeamTableEmptyRowsCount = $maxRowsCount;
                    @endphp
                @endif
                @for ($i = 1; $i <= $awayTeamTableEmptyRowsCount; $i++)
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                @endfor
            </table>

            <div style="clear: both;"></div>
        </div>

        <div class="referee">
            <p>
                Rozhodčí:
                _____________________________________________________________________________________________________________
            </p>
        </div>

        <div class="notes">
            <div>
                <p>
                    Poznámky:
                </p>
                <p>
                    _____________________________________________________________________________________________________________
                </p>
            </div>
        </div>

        <div class="captain-signatures">
            <p>
                Podpisy kapitánů:
            </p>
            <div class="captain-home">
                <p>
                    _______________________________________
                </p>
            </div>
            <div class="captain-away">
                <p>
                    _______________________________________
                </p>
            </div>

            <div style="clear: both;"></div>
        </div>

        <div class="website">
            <p>
                futsalhlinsko.cz
            </p>
        </div>

        {{-- <div class="page-break"></div> --}}
    @endforeach
@else
    <p>
        Žádné rozpisové zápasy, pro které by šlo vytvořit zápisy.
    </p>
@endif
</body>

</html>
