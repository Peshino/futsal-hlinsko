@extends('layouts.admin')

@section('title')
    {{ $game->homeTeam->name_short ?? '' }} {{ $game->home_team_score }}:{{ $game->away_team_score }}
    {{ $game->awayTeam->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.edit') @lang('messages.game') - {{ $competition->name }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content">
                <div class="content-block">
                    <form method="POST" action="{{ route('games.update', [$competition->id, $game->id]) }}"
                        autocomplete="off">
                        @csrf
                        @method('PATCH')

                        <div class="row form-group">
                            <div class="rule-id col-md">
                                <div class="floating-label">
                                    <label for="rule-id">
                                        @lang('messages.rule')
                                    </label>
                                    <select class="form-control" id="rule-id" name="rule_id" required>
                                        @if (count($competition->rules) > 0)
                                            @foreach ($competition->rules as $competitionRule)
                                                <option {{ $game->rule_id === $competitionRule->id ? 'selected' : '' }}
                                                    value="{{ $competitionRule->id }}">
                                                    {{ $competitionRule->name ?? '' }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="round col-md">
                                <div class="floating-label">
                                    <label for="round">@lang('messages.round')</label>
                                    <input type="number" class="form-control" id="round" name="round" min="0"
                                        value="{{ $game->round }}" required />
                                </div>
                            </div>
                        </div>

                        @php
                            $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                        @endphp

                        <div class="row form-group">
                            <div class="start-date col-md">
                                <div class="floating-label">
                                    <label for="start-date">@lang('messages.start_date')</label>
                                    <input type="text" class="form-control input-datepicker" id="start-date"
                                        name="start_date" autocomplete="off" value="{{ $startDateTime->toDateString() }}"
                                        required />
                                </div>
                            </div>
                            <div class="start-time col-md">
                                <div class="floating-label">
                                    <label for="start-time">@lang('messages.start_time')</label>
                                    <input type="time" class="form-control" id="start-time" name="start_time"
                                        min="00:00" max="23:59"
                                        value="{{ !empty($startDateTime) ? $startDateTime->format('H:i') : '00:00' }}"
                                        required />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="home-team-id col-md">
                                <div class="floating-label">
                                    <label for="home-team-id">
                                        @lang('messages.home_team')
                                    </label>
                                    <select id="home-team-id" name="home_team_id"
                                        @if ($homeTeamGoals->isEmpty() && $homeTeamCards->isEmpty()) class="form-control"
                                    @else
                                    class="form-control border-dark" disabled @endif>
                                        @if (count($competition->teams) > 0)
                                            <option value="">
                                                -- @lang('messages.no_team') --
                                            </option>
                                            @foreach ($competition->teams as $team)
                                                <option {{ $game->home_team_id === $team->id ? 'selected' : '' }}
                                                    value="{{ $team->id }}">
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="away-team-id col-md">
                                <div class="floating-label">
                                    <label for="away-team-id">
                                        @lang('messages.away_team')
                                    </label>
                                    <select id="away-team-id" name="away_team_id"
                                        @if ($awayTeamGoals->isEmpty() && $awayTeamCards->isEmpty()) class="form-control"
                                    @else
                                    class="form-control border-dark" disabled @endif>
                                        @if (count($competition->teams) > 0)
                                            <option value="">
                                                -- @lang('messages.no_team') --
                                            </option>
                                            @foreach ($competition->teams as $team)
                                                <option {{ $game->away_team_id === $team->id ? 'selected' : '' }}
                                                    value="{{ $team->id }}">
                                                    {{ $team->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="home-team-score col-md">
                                <div class="floating-label">
                                    <label for="home-team-score">@lang('messages.home_team_score')</label>
                                    <input type="number" class="form-control" id="home-team-score" name="home_team_score"
                                        min="0" value="{{ $game->home_team_score }}" />
                                </div>
                            </div>
                            <div class="away-team-score col-md">
                                <div class="floating-label">
                                    <label for="away-team-score">@lang('messages.away_team_score')</label>
                                    <input type="number" class="form-control" id="away-team-score" name="away_team_score"
                                        min="0" value="{{ $game->away_team_score }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="home-team-halftime-score col-md">
                                <div class="floating-label">
                                    <label for="home-team-halftime-score">@lang('messages.home_team_halftime_score')</label>
                                    <input type="number" class="form-control" id="home-team-halftime-score"
                                        name="home_team_halftime_score" min="0"
                                        value="{{ $game->home_team_halftime_score }}" />
                                </div>
                            </div>
                            <div class="away-team-halftime-score col-md">
                                <div class="floating-label">
                                    <label for="away-team-halftime-score">@lang('messages.away_team_halftime_score')</label>
                                    <input type="number" class="form-control" id="away-team-halftime-score"
                                        name="away_team_halftime_score" min="0"
                                        value="{{ $game->away_team_halftime_score }}" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <h3 class="pb-1">@lang('messages.goals')</h3>

                            <div class="row form-group">
                                <div id="home-team-goals" class="home-team-goals col-lg">
                                    @if (count($homeTeamGoals) > 0)
                                        @php
                                            $teamType = 'home';
                                            $players = $game->homeTeam->players;
                                            $team = $game->homeTeam;
                                        @endphp
                                        @foreach ($homeTeamGoals as $key => $homeTeamGoal)
                                            @php
                                                $teamGoal = $homeTeamGoal;
                                            @endphp
                                            @include('partials/goals.crud')
                                        @endforeach
                                    @endif

                                    <span class="crud-button home-team-goals-add block">
                                        <div class="plus"></div>
                                    </span>
                                </div>
                                <div id="away-team-goals" class="away-team-goals col-lg">
                                    @if (count($awayTeamGoals) > 0)
                                        @php
                                            $teamType = 'away';
                                            $players = $game->awayTeam->players;
                                            $team = $game->awayTeam;
                                        @endphp
                                        @foreach ($awayTeamGoals as $key => $awayTeamGoal)
                                            @php
                                                $teamGoal = $awayTeamGoal;
                                            @endphp
                                            @include('partials/goals.crud')
                                        @endforeach
                                    @endif

                                    <span class="crud-button away-team-goals-add block">
                                        <div class="plus"></div>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <h3 class="pb-1">@lang('messages.cards')</h3>

                            <div class="row form-group">
                                <div id="home-team-cards" class="home-team-cards col-lg">
                                    @if (count($homeTeamCards) > 0)
                                        @php
                                            $teamType = 'home';
                                            $players = $game->homeTeam->players;
                                            $team = $game->homeTeam;
                                        @endphp
                                        @foreach ($homeTeamCards as $key => $homeTeamCard)
                                            @php
                                                $teamCard = $homeTeamCard;
                                            @endphp
                                            @include('partials/cards.crud')
                                        @endforeach
                                    @endif

                                    <span class="crud-button home-team-cards-add block">
                                        <div class="plus"></div>
                                    </span>
                                </div>
                                <div id="away-team-cards" class="away-team-cards col-lg">
                                    @if (count($awayTeamCards) > 0)
                                        @php
                                            $teamType = 'away';
                                            $players = $game->awayTeam->players;
                                            $team = $game->awayTeam;
                                        @endphp
                                        @foreach ($awayTeamCards as $key => $awayTeamCard)
                                            @php
                                                $teamCard = $awayTeamCard;
                                            @endphp
                                            @include('partials/cards.crud')
                                        @endforeach
                                    @endif

                                    <span class="crud-button away-team-cards-add block">
                                        <div class="plus"></div>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="competition-id" name="competition_id"
                            value="{{ $game->competition_id }}">

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-app">@lang('messages.edit_game')</button>
                        </div>

                        @include('partials.errors')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (isset($game->homeTeam) && isset($game->awayTeam))
    @section('scripts')
        <script>
            $(() => {
                var teamTypes = ['home', 'away'];
                var statTypes = ['goal', 'card'];

                $(teamTypes).each(function(index, teamType) {
                    $(statTypes).each(function(index, statType) {
                        $addElement = $('.' + teamType + '-team-' + statType + 's-add');
                        $addElement.click(function() {
                            var html = '',
                                blockCount = $('.block').length;

                            html += '<div class="row block">';
                            html += '<div class="col-7">';
                            html += '<div class="floating-label">';
                            html += '<label for="' + teamType + '-team-' + statType +
                                '-player-' + blockCount + '">';
                            if (teamType === 'home') {
                                if (statType === 'goal') {
                                    html += '@lang('messages.home_shooter')';
                                } else {
                                    html += '@lang('messages.home_card')';
                                }
                            } else {
                                if (statType === 'goal') {
                                    html += '@lang('messages.away_shooter')';
                                } else {
                                    html += '@lang('messages.away_card')';
                                }
                            }
                            html += '</label>';

                            html += '<select class="form-control" id="' + teamType + '-team-' +
                                statType + '-player-' + blockCount + '" name="' + teamType +
                                '_team_' + statType + 's[' + blockCount +
                                '][player]" required>';
                            html += '<option value=""></option>';

                            if (teamType === 'home') {
                                html += '@if (count(isset($game->homeTeam->players) ? $game->homeTeam->players : collect()) > 0)';
                                html += '@foreach ($game->homeTeam->players as $player)';
                                html += '<option value="{{ $player->id }}">';
                                html += '{{ $player->lastname }} {{ $player->firstname }}';
                                html += '</option>';
                                html +=
                                    '@endforeach';
                                html +=
                                    '@endif';
                            } else {
                                html += '@if (count(isset($game->awayTeam->players) ? $game->awayTeam->players : collect()) > 0)';
                                html += '@foreach ($game->awayTeam->players as $player)';
                                html += '<option value="{{ $player->id }}">';
                                html += '{{ $player->lastname }} {{ $player->firstname }}';
                                html += '</option>';
                                html +=
                                    '@endforeach';
                                html +=
                                    '@endif';
                            }
                            html += '</select>';
                            html += '</div>';
                            html += '</div>';

                            if (statType === 'goal') {
                                html += '<div class="amount col-3 p-0">';
                                html += '<div class="floating-label">';
                                html += '<label for="' + teamType + '-team-' + statType +
                                    '-amount-' + blockCount + '">@lang('messages.amount')</label>';
                                html += '<input type="number" class="form-control" id="' +
                                    teamType + '-team-' + statType + '-amount-' + blockCount +
                                    '" name="' + teamType + '_team_' + statType + 's[' +
                                    blockCount +
                                    '][amount]" min="1" max="999" value="" required />';
                                html += '</div>';
                                html += '</div>';
                            } else {
                                html += '<div class="yellow-red col-3 p-0 text-center">';
                                html += '<div class="form-check form-check-inline">';
                                html += '<input class="form-check-input" type="checkbox" id="' +
                                    teamType + '-team-card-yellow-' + blockCount + '" name="' +
                                    teamType + '_team_cards[' + blockCount +
                                    '][yellow]" value="1">';
                                html += '<label class="form-check-label" for="' + teamType +
                                    '-team-card-yellow-' + blockCount + '">';
                                html += '<div class="card-yellow"></div>';
                                html += '</label>';
                                html += '</div>';
                                html += '<div class="form-check form-check-inline">';
                                html += '<input class="form-check-input" type="checkbox" id="' +
                                    teamType + '-team-card-red-' + blockCount + '" name="' +
                                    teamType + '_team_cards[' + blockCount +
                                    '][red]" value="1">';
                                html += '<label class="form-check-label" for="' + teamType +
                                    '-team-card-red-' + blockCount + '">';
                                html += '<div class="card-red"></div>';
                                html += '</label>';
                                html += '</div>';
                                html += '</div>';
                            }

                            if (teamType === 'home') {
                                html += '<input type="hidden" name="' + teamType + '_team_' +
                                    statType + 's[' + blockCount +
                                    '][team]" value="{{ $game->homeTeam->id }}">';
                            } else {
                                html += '<input type="hidden" name="' + teamType + '_team_' +
                                    statType + 's[' + blockCount +
                                    '][team]" value="{{ $game->awayTeam->id }}">';
                            }

                            html += '<div class="delete col-2 pt-2">';
                            html += '<span class="crud-button">';
                            html += '<i class="far fa-trash-alt"></i>';
                            html += '</span>';
                            html += '</div>';

                            html += '</div>';

                            $('#' + teamType + '-team-' + statType + 's .block:last').before(
                                html);
                        });

                        $('#' + teamType + '-team-' + statType + 's').on('click', '.delete',
                            function() {
                                $(this).parent().remove();
                            });
                    });
                });
            });
        </script>
    @endsection
@endif
