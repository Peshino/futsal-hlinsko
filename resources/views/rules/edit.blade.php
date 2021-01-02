@extends('layouts.admin')

@section('title')
@lang('messages.edit') @lang('messages.' . $rule->name ?? '' . '') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.edit') @lang('messages.' . $rule->name ?? '' . '') - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <form method="POST" action="{{ route('rules.update', [$competition->id, $rule->id]) }}"
                    autocomplete="off">
                    @csrf
                    @method('PATCH')

                    <div class="row form-group">
                        <div class="name col-md">
                            <div class="floating-label">
                                <label for="name">
                                    @lang('messages.name')
                                </label>
                                <select class="form-control" id="name" name="name" required>
                                    <option {{ $rule->name === 'main' ? "selected" : "" }} value="main">
                                        @lang('messages.main')
                                    </option>
                                    <option {{ $rule->name === 'qualification' ? "selected" : "" }}
                                        value="qualification">
                                        @lang('messages.qualification')
                                    </option>
                                    <option {{ $rule->name === 'descent' ? "selected" : "" }} value="descent">
                                        @lang('messages.descent')
                                    </option>
                                    <option {{ $rule->name === 'playoff' ? "selected" : "" }} value="playoff">
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
                                    <option {{ $rule->system === 'one_rounded' ? "selected" : "" }} value="one_rounded">
                                        @lang('messages.one_rounded')
                                    </option>
                                    <option {{ $rule->system === 'two_rounded' ? "selected" : "" }} value="two_rounded">
                                        @lang('messages.two_rounded')
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
                                    value="{{ $rule->priority }}" required />
                            </div>
                        </div>
                        <div class="number-of-rounds col-md">
                            <div class="floating-label">
                                <label for="number-of-rounds">@lang('messages.number_of_rounds')</label>
                                <input type="number" class="form-control" id="number-of-rounds" name="number_of_rounds"
                                    min="0" value="{{ $rule->number_of_rounds }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="number-of-qualifiers col-md">
                            <div class="floating-label">
                                <label for="number-of-qualifiers">@lang('messages.number_of_qualifiers')</label>
                                <input type="number" class="form-control" id="number-of-qualifiers"
                                    name="number_of_qualifiers" min="0" value="{{ $rule->number_of_qualifiers }}" />
                            </div>
                        </div>
                        <div class="number-of-descending col-md">
                            <div class="floating-label">
                                <label for="number-of-descending">@lang('messages.number_of_descending')</label>
                                <input type="number" class="form-control" id="number-of-descending"
                                    name="number_of_descending" min="0" value="{{ $rule->number_of_descending }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="match-duration col-md">
                            <div class="floating-label">
                                <label for="match-duration">@lang('messages.match_duration')</label>
                                <input type="number" class="form-control" id="match-duration" name="match_duration"
                                    min="0" value="{{ $rule->match_duration }}" />
                            </div>
                        </div>
                        <div class="points-for-win col-md">
                            <div class="floating-label">
                                <label for="points-for-win">@lang('messages.points_for_win')</label>
                                <input type="number" class="form-control" id="points-for-win" name="points_for_win"
                                    min="0" value="{{ $rule->points_for_win }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="matches-day-min col-md">
                            <div class="floating-label">
                                <label for="matches-day-min">@lang('messages.matches_day_min')</label>
                                <input type="number" class="form-control" id="matches-day-min" name="matches_day_min"
                                    min="0" value="{{ $rule->matches_day_min }}" />
                            </div>
                        </div>
                        <div class="matches-day-max col-md">
                            <div class="floating-label">
                                <label for="matches-day-max">@lang('messages.matches_day_max')</label>
                                <input type="number" class="form-control" id="matches-day-max" name="matches_day_max"
                                    min="0" value="{{ $rule->matches_day_max }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="team-matches-day-round-min col-md">
                            <div class="floating-label">
                                <label
                                    for="team-matches-day-round-min">@lang('messages.team_matches_day_round_min')</label>
                                <input type="number" class="form-control" id="team-matches-day-round-min"
                                    name="team_matches_day_round_min" min="0"
                                    value="{{ $rule->team_matches_day_round_min }}" />
                            </div>
                        </div>
                        <div class="team-matches-day-round-max col-md">
                            <div class="floating-label">
                                <label
                                    for="team-matches-day-round-max">@lang('messages.team_matches_day_round_max')</label>
                                <input type="number" class="form-control" id="team-matches-day-round-max"
                                    name="team_matches_day_round_max" min="0"
                                    value="{{ $rule->team_matches_day_round_max }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="match-days-times col-md">
                            <div class="floating-label">
                                <label for="match-days-times">@lang('messages.match_days_times')</label>
                                <input type="text" class="form-control" id="match-days-times" name="match_days_times"
                                    value="{{ $rule->match_days_times }}" required />
                            </div>
                        </div>
                        <div class="case_of_draw col-md">
                            <div class="floating-label">
                                <label for="case-of-draw">
                                    @lang('messages.case_of_draw')
                                </label>
                                <select class="form-control" id="case-of-draw" name="case_of_draw" required>
                                    <option {{ $rule->case_of_draw === 'draw' ? "selected" : "" }} value="draw">
                                        @lang('messages.draw')
                                    </option>
                                    <option {{ $rule->case_of_draw === 'additional_time' ? "selected" : "" }}
                                        value="additional_time">
                                        @lang('messages.additional_time')
                                    </option>
                                    <option {{ $rule->case_of_draw === 'penalties' ? "selected" : "" }}
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
                                    name="start_date" autocomplete="off" value="{{ $rule->start_date }}" required />
                            </div>
                        </div>
                        <div class="end-date col-md">
                            <div class="floating-label">
                                <label for="end-date">@lang('messages.end_date')</label>
                                <input type="text" class="form-control input-datepicker" id="end-date" name="end_date"
                                    autocomplete="off" value="{{ $rule->end_date }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="break-start-date col-md">
                            <div class="floating-label">
                                <label for="break-start-date">@lang('messages.break_start_date')</label>
                                <input type="text" class="form-control input-datepicker" id="break-start-date"
                                    name="break_start_date" autocomplete="off" value="{{ $rule->break_start_date }}" />
                            </div>
                        </div>
                        <div class="break-end-date col-md">
                            <div class="floating-label">
                                <label for="break-end-date">@lang('messages.break_end_date')</label>
                                <input type="text" class="form-control input-datepicker" id="break-end-date"
                                    name="break_end_date" autocomplete="off" value="{{ $rule->break_end_date }}" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $rule->competition_id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.edit_rules')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection