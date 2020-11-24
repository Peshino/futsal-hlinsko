@extends('layouts.admin')

@section('title')
@lang('messages.create_match') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.create_match') - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('matches.store', $competition->id) }}">
                    @csrf

                    <div class="row form-group">
                        <div class="rule-id col-md">
                            <div class="floating-label">
                                <label for="rule-id">
                                    @lang('messages.rule')
                                </label>
                                <select class="form-control" id="rule-id" name="rule_id" required>
                                    @if (count($competition->rules) > 0)
                                    @foreach ($competition->rules as $rule)
                                    <option {{ old('rule_id') === $rule->id ? "selected" : "" }}
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
                                    value="{{ old('round') }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="start-date col-md">
                            <div class="floating-label">
                                <label for="start-date">@lang('messages.start_date')</label>
                                <input type="text" class="form-control input-datepicker" id="start-date"
                                    name="start_date" autocomplete="off" value="{{ old('start_date') }}" required />
                            </div>
                        </div>
                        <div class="start-time col-md">
                            <div class="floating-label">
                                <label for="start-time">@lang('messages.start_time')</label>
                                <input type="time" class="form-control" id="start-time" name="start_time" min="00:00"
                                    max="23:59" value="{{ !empty(old('start_time')) ? old('start_time') : '00:00' }}"
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
                                    <option {{ old('home_team_id') === $team->id ? "selected" : "" }}
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
                                    <option {{ old('away_team_id') === $team->id ? "selected" : "" }}
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
                                    min="0" value="{{ old('home_team_score') }}" />
                            </div>
                        </div>
                        <div class="away-team-score col-md">
                            <div class="floating-label">
                                <label for="away-team-score">@lang('messages.away_team_score')</label>
                                <input type="number" class="form-control" id="away-team-score" name="away_team_score"
                                    min="0" value="{{ old('away_team_score') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="home-team-halftime-score col-md">
                            <div class="floating-label">
                                <label for="home-team-halftime-score">@lang('messages.home_team_halftime_score')</label>
                                <input type="number" class="form-control" id="home-team-halftime-score"
                                    name="home_team_halftime_score" min="0"
                                    value="{{ old('home_team_halftime_score') }}" />
                            </div>
                        </div>
                        <div class="away-team-halftime-score col-md">
                            <div class="floating-label">
                                <label for="away-team-halftime-score">@lang('messages.away_team_halftime_score')</label>
                                <input type="number" class="form-control" id="away-team-halftime-score"
                                    name="away_team_halftime_score" min="0"
                                    value="{{ old('away_team_halftime_score') }}" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $competition->id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.create_match')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection