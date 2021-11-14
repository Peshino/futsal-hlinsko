@extends('layouts.admin')

@section('title')
@lang('messages.edit') {{ $rule->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.edit') {{ $rule->name ?? '' }} - {{ $competition->name }}
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
                                <label for="name">@lang('messages.name')</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $rule->name }}"
                                    required />
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
                        <div class="display-as col-md">
                            <div class="floating-label">
                                <label for="display-as">
                                    @lang('messages.type')
                                </label>
                                <select class="form-control" id="display-as" name="type" required>
                                    <option {{ $rule->type === 'table' ? "selected" : "" }} value="table">
                                        @lang('messages.table')
                                    </option>
                                    <option {{ $rule->type === 'brackets' ? "selected" : "" }} value="brackets">
                                        @lang('messages.brackets')
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group text-center p-2">
                        <div class="apply-mutual-balance col-md">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="apply-mutual-balance"
                                    name="apply_mutual_balance" value="{{ $rule->apply_mutual_balance === 1 ? 1 : 0 }}"
                                    {{ $rule->apply_mutual_balance === 1 ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                    for="apply-mutual-balance">@lang('messages.apply_mutual_balance')</label>
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
                        <div class="game-duration col-md">
                            <div class="floating-label">
                                <label for="game-duration">@lang('messages.game_duration')
                                    (@lang('messages.minutes'))</label>
                                <input type="number" class="form-control" id="game-duration" name="game_duration"
                                    min="0" value="{{ $rule->game_duration }}" required />
                            </div>
                        </div>
                        <div class="points-for-win col-md">
                            <div class="floating-label">
                                <label for="points-for-win">@lang('messages.points_for_win')</label>
                                <input type="number" class="form-control" id="points-for-win" name="points_for_win"
                                    min="0" value="{{ $rule->points_for_win }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="games-day-min col-md">
                            <div class="floating-label">
                                <label for="games-day-min">@lang('messages.games_day_min')</label>
                                <input type="number" class="form-control" id="games-day-min" name="games_day_min"
                                    min="0" value="{{ $rule->games_day_min }}" />
                            </div>
                        </div>
                        <div class="games-day-max col-md">
                            <div class="floating-label">
                                <label for="games-day-max">@lang('messages.games_day_max')</label>
                                <input type="number" class="form-control" id="games-day-max" name="games_day_max"
                                    min="0" value="{{ $rule->games_day_max }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="team-games-day-round-min col-md">
                            <div class="floating-label">
                                <label for="team-games-day-round-min">@lang('messages.team_games_day_round_min')</label>
                                <input type="number" class="form-control" id="team-games-day-round-min"
                                    name="team_games_day_round_min" min="0"
                                    value="{{ $rule->team_games_day_round_min }}" />
                            </div>
                        </div>
                        <div class="team-games-day-round-max col-md">
                            <div class="floating-label">
                                <label for="team-games-day-round-max">@lang('messages.team_games_day_round_max')</label>
                                <input type="number" class="form-control" id="team-games-day-round-max"
                                    name="team_games_day_round_max" min="0"
                                    value="{{ $rule->team_games_day_round_max }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="game-days-times col-md">
                            <div class="floating-label">
                                <label for="game-days-times">@lang('messages.game_days_times')</label>
                                <input type="text" class="form-control" id="game-days-times" name="game_days_times"
                                    value="{{ $rule->game_days_times }}" required />
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

                    <div class="mt-3 text-left">
                        <h4 class="pt-2 pb-2">
                            @lang('messages.teams')
                        </h4>

                        <div class="row">
                            @foreach ($teams->chunk(count($teams) / 2) as $teamCollection)
                            <div class="form-check col-sm">
                                @foreach($teamCollection as $team)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" {{ $team->is_in_rule ? "checked" :
                                    "" }} name="teams[]" value="{{ $team->id }}"
                                    id="team-{{ $team->id }}">
                                    <label class="form-check-label" for="team-{{ $team->id }}">
                                        {{ $team->name }}
                                    </label>
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
                                @include('partials/phases.crud')
                                @endforeach
                                @endif
                                <span class="crud-button phases-add block">
                                    <div class="plus"></div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $rule->competition_id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-app">@lang('messages.edit_rules')</button>
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
    $(() => {
        $addElement = $('.phases-add');
        $addElement.click(function() {
            var html = '',
                blockCount = $('.block').length;
            
            html += '<div class="row block">';
                html += '<div class="from-position col-md-2">';
                    html += '<div class="floating-label">';
                        html += '<label for="phase-from-position-' + blockCount + '">';
                            html += '@lang("messages.from_position")';
                        html += '</label>';
                        html += '<input type="number" class="form-control" id="phase-from-position-' + blockCount + '" name="phases[' + blockCount + '][from_position]" min="1" max="999" value="" required />';
                    html += '</div>';
                html += '</div>';

                html += '<div class="to-position col-md-2">';
                    html += '<div class="floating-label">';
                        html += '<label for="phase-to-position-' + blockCount + '">';
                            html += '@lang("messages.to_position")';
                        html += '</label>';
                        html += '<input type="number" class="form-control" id="phase-to-position-' + blockCount + '" name="phases[' + blockCount + '][to_position]" min="1" max="999" value="" required />';
                    html += '</div>';
                html += '</div>';

                html += '<div class="phase col-md-2">';
                    html += '<div class="floating-label">';
                        html += '<label for="phase-phase-' + blockCount + '">';
                            html += '@lang("messages.phase")';
                        html += '</label>';
                        html += '<select class="form-control" id="phase-phase-' + blockCount + '" name="phases[' + blockCount + '][phase]">';
                            html += '<option value=""></option>';
                            html += '<option value="qualification">';
                                html += '@lang("messages.qualification")';
                            html += '</option>';
                            html += '<option value="descent">';
                                html += '@lang("messages.descent")';
                            html += '</option>';
                        html += '</select>';
                    html += '</div>';
                html += '</div>';

                html += '<div class="to-rule col-md-5">';
                    html += '<div class="floating-label">';
                        html += '<label for="phase-to-rule-' + blockCount + '">';
                            html += '@lang("messages.to_rule")';
                        html += '</label>';
                        html += '<select class="form-control" id="phase-to-rule-' + blockCount + '" name="phases[' + blockCount + '][to_rule_id]" required>';
                            html += '<option value="{{ $rule->id }}"></option>';
                            html += '@foreach ($competition->rules as $competitionRule)';
                            html += '@if ($rule->id === $competitionRule->id)';
                            html += '{{ $rule->id }}';
                            html += '@continue';
                            html += '@endif';
                            html += '<option value="{{ $competitionRule->id }}">';
                                html += '{{ $competitionRule->name }}';
                            html += '</option>';
                            html += '@endforeach';
                        html += '</select>';
                    html += '</div>';
                html += '</div>';

                html += '<div class="delete col-1 pt-2">';
                    html += '<span class="crud-button">';
                        html += '<i class="far fa-trash-alt"></i>';
                    html += '</span>';
                html += '</div>';

            html += '</div>';

            $('#phases .block:last').before(html);
        });

        $('#phases').on('click', '.delete', function() {
            $(this).parent().remove();
        });
    });
</script>
@endsection