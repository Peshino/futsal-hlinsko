@extends('layouts.admin')

@section('title')
    {{ $rule->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    {{ $rule->name ?? '' }} - {{ $competition->name }}
                </div>

                <div class="col">
                    <ul class="list-inline justify-content-end">
                        <li class="list-inline-item">
                            <a class="crud-button" href="{{ route('rules.edit', [$competition->id, $rule->id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <form method="POST" action="{{ route('rules.destroy', [$competition->id, $rule->id]) }}"
                                autocomplete="off">
                                @csrf
                                @method('DELETE')

                                @include('partials/modals.delete')
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content">
                <div class="content-block">
                    <div class="row form-group">
                        <div class="name col-md">
                            <div class="floating-label">
                                <label for="name">@lang('messages.name')</label>
                                <input type="text" class="form-control border-dark" id="name" name="name"
                                    value="{{ $rule->name }}" disabled />
                            </div>
                        </div>
                        <div class="system col-md">
                            <div class="floating-label">
                                <label for="system">
                                    @lang('messages.system')
                                </label>
                                <select class="form-control border-dark" id="system" name="system" disabled>
                                    <option {{ $rule->system === 'one_rounded' ? 'selected' : '' }} value="one_rounded">
                                        @lang('messages.one_rounded')
                                    </option>
                                    <option {{ $rule->system === 'two_rounded' ? 'selected' : '' }} value="two_rounded">
                                        @lang('messages.two_rounded')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="display-as col-md">
                            <div class="floating-label">
                                <label for="display-as">
                                    @lang('messages.type')
                                </label>
                                <select class="form-control border-dark" id="display-as" name="type" disabled>
                                    <option {{ $rule->type === 'table' ? 'selected' : '' }} value="table">
                                        @lang('messages.table')
                                    </option>
                                    <option {{ $rule->type === 'brackets' ? 'selected' : '' }} value="brackets">
                                        @lang('messages.brackets')
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if ($rule->type === 'table')
                        <div class="row form-group text-center p-2">
                            <div class="apply-mutual-balance col-md">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="apply-mutual-balance"
                                        name="apply_mutual_balance" value="{{ $rule->apply_mutual_balance === 1 ? 1 : 0 }}"
                                        {{ $rule->apply_mutual_balance === 1 ? 'checked' : '' }} disabled>
                                    <label class="custom-control-label"
                                        for="apply-mutual-balance">@lang('messages.apply_mutual_balance')</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row form-group">
                        <div class="priority col-md">
                            <div class="floating-label">
                                <label for="priority">@lang('messages.priority')</label>
                                <input type="number" class="form-control border-dark" id="priority" name="priority"
                                    min="0" value="{{ $rule->priority }}" disabled />
                            </div>
                        </div>
                        <div class="number-of-rounds col-md">
                            <div class="floating-label">
                                <label for="number-of-rounds">@lang('messages.number_of_rounds')</label>
                                <input type="number" class="form-control border-dark" id="number-of-rounds"
                                    name="number_of_rounds" min="0" value="{{ $rule->number_of_rounds }}"
                                    disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="game-duration col-md">
                            <div class="floating-label">
                                <label for="game-duration">@lang('messages.game_duration')
                                    (@lang('messages.minutes'))</label>
                                <input type="number" class="form-control border-dark" id="game-duration"
                                    name="game_duration" min="0" value="{{ $rule->game_duration }}" disabled />
                            </div>
                        </div>
                        <div class="points-for-win col-md">
                            <div class="floating-label">
                                <label for="points-for-win">@lang('messages.points_for_win')</label>
                                <input type="number" class="form-control border-dark" id="points-for-win"
                                    name="points_for_win" min="0" value="{{ $rule->points_for_win }}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="games-day-min col-md">
                            <div class="floating-label">
                                <label for="games-day-min">@lang('messages.games_day_min')</label>
                                <input type="number" class="form-control border-dark" id="games-day-min"
                                    name="games_day_min" min="0" value="{{ $rule->games_day_min }}" disabled />
                            </div>
                        </div>
                        <div class="games-day-max col-md">
                            <div class="floating-label">
                                <label for="games-day-max">@lang('messages.games_day_max')</label>
                                <input type="number" class="form-control border-dark" id="games-day-max"
                                    name="games_day_max" min="0" value="{{ $rule->games_day_max }}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="team-games-day-round-min col-md">
                            <div class="floating-label">
                                <label for="team-games-day-round-min">@lang('messages.team_games_day_round_min')</label>
                                <input type="number" class="form-control border-dark" id="team-games-day-round-min"
                                    name="team_games_day_round_min" min="0"
                                    value="{{ $rule->team_games_day_round_min }}" disabled />
                            </div>
                        </div>
                        <div class="team-games-day-round-max col-md">
                            <div class="floating-label">
                                <label for="team-games-day-round-max">@lang('messages.team_games_day_round_max')</label>
                                <input type="number" class="form-control border-dark" id="team-games-day-round-max"
                                    name="team_games_day_round_max" min="0"
                                    value="{{ $rule->team_games_day_round_max }}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="game-days-times col-md">
                            <div class="floating-label">
                                <label for="game-days-times">@lang('messages.game_days_times')</label>
                                <input type="text" class="form-control border-dark" id="game-days-times"
                                    name="game_days_times" value="{{ $rule->game_days_times }}" disabled />
                            </div>
                        </div>
                        <div class="case_of_draw col-md">
                            <div class="floating-label">
                                <label for="case-of-draw">
                                    @lang('messages.case_of_draw')
                                </label>
                                <select class="form-control border-dark" id="case-of-draw" name="case_of_draw" disabled>
                                    <option {{ $rule->case_of_draw === 'draw' ? 'selected' : '' }} value="draw">
                                        @lang('messages.draw')
                                    </option>
                                    <option {{ $rule->case_of_draw === 'additional_time' ? 'selected' : '' }}
                                        value="additional_time">
                                        @lang('messages.additional_time')
                                    </option>
                                    <option {{ $rule->case_of_draw === 'penalties' ? 'selected' : '' }} value="penalties">
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
                                <input type="text" class="form-control border-dark" id="start-date" name="start_date"
                                    value="{{ $rule->start_date }}" disabled />
                            </div>
                        </div>
                        <div class="end-date col-md">
                            <div class="floating-label">
                                <label for="end-date">@lang('messages.end_date')</label>
                                <input type="text" class="form-control border-dark" id="end-date" name="end_date"
                                    value="{{ $rule->end_date }}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="break-start-date col-md">
                            <div class="floating-label">
                                <label for="break-start-date">@lang('messages.break_start_date')</label>
                                <input type="text" class="form-control border-dark" id="break-start-date"
                                    name="break_start_date" value="{{ $rule->break_start_date }}" disabled />
                            </div>
                        </div>
                        <div class="break-end-date col-md">
                            <div class="floating-label">
                                <label for="break-end-date">@lang('messages.break_end_date')</label>
                                <input type="text" class="form-control border-dark" id="break-end-date"
                                    name="break_end_date" value="{{ $rule->break_end_date }}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-left">
                        <h4 class="pt-2 pb-2">
                            @lang('messages.teams')
                        </h4>

                        <div class="row">
                            @foreach ($teams->chunk(count($teams) / 2) as $teamCollection)
                                <div class="form-check col-sm">
                                    @foreach ($teamCollection as $team)
                                        <div class="form-check mb-2">
                                            <p>
                                                <a href="{{ route('teams.show', [$competition->id, $team->id]) }}">
                                                    {{ $team->name }}
                                                </a>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 mb-2">
                        <h3 class="pb-1">
                            @lang('messages.phases')
                        </h3>

                        <div class="row form-group">
                            <div id="phases" class="phases col-lg">
                                @if (count($phases) > 0)
                                    @foreach ($phases as $key => $phase)
                                        @include('partials/phases.show')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
