@extends('layouts.admin')

@section('title')
{{ $game->homeTeam->name_short }} {{ $game->home_team_score }}:{{ $game->away_team_score }}
{{ $game->awayTeam->name_short }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
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
                                    @foreach ($competition->rules as $rule)
                                    <option {{ $game->rule_id === $rule->id ? "selected" : "" }}
                                        value="{{ $rule->id }}">
                                        @lang('messages.' . $rule->name ?? '' . '')
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
                                <input type="time" class="form-control" id="start-time" name="start_time" min="00:00"
                                    max="23:59"
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
                                <select class="form-control" id="home-team-id" name="home_team_id" required>
                                    @if (count($competition->teams) > 0)
                                    @foreach ($competition->teams as $team)
                                    <option {{ $game->home_team_id === $team->id ? "selected" : "" }}
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
                                <select class="form-control" id="away-team-id" name="away_team_id" required>
                                    @if (count($competition->teams) > 0)
                                    @foreach ($competition->teams as $team)
                                    <option {{ $game->away_team_id === $team->id ? "selected" : "" }}
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
                            <div id="home-team-goals" class="home-team-goals col-md">
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
                                @include('partials/goals-crud')
                                @endforeach
                                @endif

                                <span class="crud-button home-team-goals-add block">
                                    <div class="plus"></div>
                                </span>
                            </div>
                            <div id="away-team-goals" class="away-team-goals col-md">
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
                                @include('partials/goals-crud')
                                @endforeach
                                @endif

                                <span class="crud-button away-team-goals-add block">
                                    <div class="plus"></div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $game->competition_id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.edit_game')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var teamTypes = ['home', 'away'];
        
        $(teamTypes).each(function(index, teamType) {
            $('.' + teamType + '-team-goals-add').click(function() {
                var html = '',
                    blockCount = $('.block').length;
                
                html += '<div class="row block">';
                    html += '<div class="col-8">';
                        html += '<div class="floating-label">';
                            html += '<label for="' + teamType + '-team-goal-player-' + blockCount + '">';
                
                            if (teamType === 'home') {
                                html += '@lang("messages.home_shooter")';
                            } else {
                                html += '@lang("messages.away_shooter")';
                            }
                
                            html += '</label>';
                            html += '<select class="form-control" id="' + teamType + '-team-goal-player-' + blockCount + '" name="' + teamType + '_team_goals[' + blockCount + '][player]">';
                                html += '<option value=""></option>';
                
                            if (teamType === 'home') {
                                html += '@if (count($game->homeTeam->players) > 0)';
                                html += '@foreach ($game->homeTeam->players as $player)';
                                html += '<option value="{{ $player->id }}">';
                                    html += '{{ $player->lastname }} {{ $player->firstname }}';
                                    html += '</option>';
                                html += '@endforeach';
                                html += '@endif';
                            } else {
                                html += '@if (count($game->awayTeam->players) > 0)';
                                html += '@foreach ($game->awayTeam->players as $player)';
                                html += '<option value="{{ $player->id }}">';
                                    html += '{{ $player->lastname }} {{ $player->firstname }}';
                                    html += '</option>';
                                html += '@endforeach';
                                html += '@endif';
                            }
                                html += '</select>';
                            html += '</div>';
                        html += '</div>';
                    html += '<div class="amount col-2 no-padding">';
                        html += '<div class="floating-label">';
                            html += '<label for="' + teamType + '-team-goal-amount-' + blockCount + '">@lang("messages.amount")</label>';
                            html += '<input type="number" class="form-control" id="' + teamType + '-team-goal-amount-' + blockCount + '" name="' + teamType + '_team_goals[' + blockCount + '][amount]" min="1" max="999" value="" />';
                        html += '</div>';
                    html += '</div>';
                    if (teamType === 'home') {
                        html += '<input type="hidden" name="' + teamType + '_team_goals[' + blockCount + '][team]" value="{{ $game->homeTeam->id }}">';
                    } else {
                        html += '<input type="hidden" name="' + teamType + '_team_goals[' + blockCount + '][team]" value="{{ $game->awayTeam->id }}">';
                    }
                    html += '<div class="delete col-2 pt-2">';
                        html += '<span class="crud-button">';
                            html += '<i class="far fa-trash-alt"></i>';
                        html += '</span>';
                    html += '</div>';
                html += '</div>';

                $('#' + teamType + '-team-goals .block:last').before(html);
            });

            $('#' + teamType + '-team-goals').on('click', '.delete', function() {
                $(this).parent().remove();
            });
        });
    });
</script>
@endsection