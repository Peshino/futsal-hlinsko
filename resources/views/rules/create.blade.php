@extends('layouts.admin')

@section('title')
@lang('messages.create_rules') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.create_rules') - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('rules.store', $competition->id) }}">
                    @csrf

                    <div class="row form-group">
                        <div class="name col-md">
                            <div class="floating-label">
                                <label for="name">
                                    @lang('messages.name')
                                </label>
                                <select class="form-control" id="name" name="name" required>
                                    <option {{ old('name') === 'main' ? "selected" : "" }} value="main">
                                        @lang('messages.main')
                                    </option>
                                    <option {{ old('name') === 'qualification' ? "selected" : "" }}
                                        value="qualification">
                                        @lang('messages.qualification')
                                    </option>
                                    <option {{ old('name') === 'descent' ? "selected" : "" }} value="descent">
                                        @lang('messages.descent')
                                    </option>
                                    <option {{ old('name') === 'playoff' ? "selected" : "" }} value="playoff">
                                        @lang('messages.playoff')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="system col-md">
                            <div class="floating-label">
                                <label for="system">
                                    @lang('messages.system')
                                </label>
                                <select class="form-control" id="system" name="system" required>
                                    <option {{ old('system') === 'one_rounded' ? "selected" : "" }} value="one_rounded">
                                        @lang('messages.one_rounded')
                                    </option>
                                    <option {{ old('system') === 'two_rounded' ? "selected" : "" }} value="two_rounded">
                                        @lang('messages.two_rounded')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="display-as col-md">
                            <div class="floating-label">
                                <label for="display-as">
                                    @lang('messages.display_as')
                                </label>
                                <select class="form-control" id="display-as" name="display_as" required>
                                    <option {{ old('display_as') === 'table' ? "selected" : "" }} value="table">
                                        @lang('messages.table')
                                    </option>
                                    <option {{ old('display_as') === 'brackets' ? "selected" : "" }} value="brackets">
                                        @lang('messages.brackets')
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="priority col-md">
                            <div class="floating-label">
                                <label for="priority">@lang('messages.priority')</label>
                                <input type="number" class="form-control" id="priority" name="priority" min="0"
                                    value="{{ old('priority') }}" required />
                            </div>
                        </div>
                        <div class="number-of-rounds col-md">
                            <div class="floating-label">
                                <label for="number-of-rounds">@lang('messages.number_of_rounds')</label>
                                <input type="number" class="form-control" id="number-of-rounds" name="number_of_rounds"
                                    min="0" value="{{ old('number_of_rounds') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="number-of-qualifiers col-md">
                            <div class="floating-label">
                                <label for="number-of-qualifiers">@lang('messages.number_of_qualifiers')</label>
                                <input type="number" class="form-control" id="number-of-qualifiers"
                                    name="number_of_qualifiers" min="0" value="{{ old('number_of_qualifiers') }}" />
                            </div>
                        </div>
                        <div class="number-of-descending col-md">
                            <div class="floating-label">
                                <label for="number-of-descending">@lang('messages.number_of_descending')</label>
                                <input type="number" class="form-control" id="number-of-descending"
                                    name="number_of_descending" min="0" value="{{ old('number_of_descending') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="game-duration col-md">
                            <div class="floating-label">
                                <label for="game-duration">@lang('messages.game_duration')
                                    (@lang('messages.minutes'))</label>
                                <input type="number" class="form-control" id="game-duration" name="game_duration"
                                    min="0" value="{{ old('game_duration') }}" required />
                            </div>
                        </div>
                        <div class="points-for-win col-md">
                            <div class="floating-label">
                                <label for="points-for-win">@lang('messages.points_for_win')</label>
                                <input type="number" class="form-control" id="points-for-win" name="points_for_win"
                                    min="0" value="{{ old('points_for_win') }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="games-day-min col-md">
                            <div class="floating-label">
                                <label for="games-day-min">@lang('messages.games_day_min')</label>
                                <input type="number" class="form-control" id="games-day-min" name="games_day_min"
                                    min="0" value="{{ old('games_day_min') }}" />
                            </div>
                        </div>
                        <div class="games-day-max col-md">
                            <div class="floating-label">
                                <label for="games-day-max">@lang('messages.games_day_max')</label>
                                <input type="number" class="form-control" id="games-day-max" name="games_day_max"
                                    min="0" value="{{ old('games_day_max') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="team-games-day-round-min col-md">
                            <div class="floating-label">
                                <label for="team-games-day-round-min">@lang('messages.team_games_day_round_min')</label>
                                <input type="number" class="form-control" id="team-games-day-round-min"
                                    name="team_games_day_round_min" min="0"
                                    value="{{ old('team_games_day_round_min') }}" />
                            </div>
                        </div>
                        <div class="team-games-day-round-max col-md">
                            <div class="floating-label">
                                <label for="team-games-day-round-max">@lang('messages.team_games_day_round_max')</label>
                                <input type="number" class="form-control" id="team-games-day-round-max"
                                    name="team_games_day_round_max" min="0"
                                    value="{{ old('team_games_day_round_max') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="game-days-times col-md">
                            <div class="floating-label">
                                <label for="game-days-times">@lang('messages.game_days_times')</label>
                                <input type="text" class="form-control" id="game-days-times" name="game_days_times"
                                    value="{{ old('game_days_times') }}" required />
                            </div>
                        </div>
                        <div class="case_of_draw col-md">
                            <div class="floating-label">
                                <label for="case-of-draw">
                                    @lang('messages.case_of_draw')
                                </label>
                                <select class="form-control" id="case-of-draw" name="case_of_draw" required>
                                    <option {{ old('case_of_draw') === 'draw' ? "selected" : "" }} value="draw">
                                        @lang('messages.draw')
                                    </option>
                                    <option {{ old('case_of_draw') === 'additional_time' ? "selected" : "" }}
                                        value="additional_time">
                                        @lang('messages.additional_time')
                                    </option>
                                    <option {{ old('case_of_draw') === 'penalties' ? "selected" : "" }}
                                        value="penalties">
                                        @lang('messages.penalties')
                                    </option>
                                </select>
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
                        <div class="end-date col-md">
                            <div class="floating-label">
                                <label for="end-date">@lang('messages.end_date')</label>
                                <input type="text" class="form-control input-datepicker" id="end-date" name="end_date"
                                    autocomplete="off" value="{{ old('end_date') }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="break-start-date col-md">
                            <div class="floating-label">
                                <label for="break-start-date">@lang('messages.break_start_date')</label>
                                <input type="text" class="form-control input-datepicker" id="break-start-date"
                                    name="break_start_date" autocomplete="off" value="{{ old('break_start_date') }}" />
                            </div>
                        </div>
                        <div class="break-end-date col-md">
                            <div class="floating-label">
                                <label for="break-end-date">@lang('messages.break_end_date')</label>
                                <input type="text" class="form-control input-datepicker" id="break-end-date"
                                    name="break_end_date" autocomplete="off" value="{{ old('break_end_date') }}" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $competition->id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.create_rules')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection