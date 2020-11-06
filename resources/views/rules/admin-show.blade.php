@extends('layouts.admin')

@section('title')
@lang('messages.' . $rule->name ?? '' . '') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.' . $rule->name ?? '' . '') - {{ $competition->name }}
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
                            <button class="crud-button" type="button" data-toggle="modal"
                                data-target="#modal-rule-delete"><i class="far fa-trash-alt"></i></button>

                            <div class="modal fade" id="modal-rule-delete" tabindex="-1" role="dialog"
                                aria-labelledby="modal-rule-delete-title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-rule-delete-title">
                                                @lang('messages.really_delete')
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                @lang('messages.delete')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <label for="name">
                                @lang('messages.name')
                            </label>
                            <select class="form-control border-dark" id="name" name="name" disabled>
                                <option {{ $rule->name === 'main' ? "selected" : "" }} value="main">
                                    @lang('messages.main')
                                </option>
                                <option {{ $rule->name === 'qualification' ? "selected" : "" }} value="qualification">
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
                            <select class="form-control border-dark" id="system" name="system" disabled>
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
                            <input type="number" class="form-control border-dark" id="priority" name="priority" min="0"
                                value="{{ $rule->priority }}" disabled />
                        </div>
                    </div>
                    <div class="number-of-rounds col-md">
                        <div class="floating-label">
                            <label for="number-of-rounds">@lang('messages.number_of_rounds')</label>
                            <input type="number" class="form-control border-dark" id="number-of-rounds"
                                name="number_of_rounds" min="0" value="{{ $rule->number_of_rounds }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="number-of-qualifiers col-md">
                        <div class="floating-label">
                            <label for="number-of-qualifiers">@lang('messages.number_of_qualifiers')</label>
                            <input type="number" class="form-control border-dark" id="number-of-qualifiers"
                                name="number_of_qualifiers" min="0" value="{{ $rule->number_of_qualifiers }}"
                                disabled />
                        </div>
                    </div>
                    <div class="number-of-descending col-md">
                        <div class="floating-label">
                            <label for="number-of-descending">@lang('messages.number_of_descending')</label>
                            <input type="number" class="form-control border-dark" id="number-of-descending"
                                name="number_of_descending" min="0" value="{{ $rule->number_of_descending }}"
                                disabled />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="match-duration col-md">
                        <div class="floating-label">
                            <label for="match-duration">@lang('messages.match_duration')</label>
                            <input type="number" class="form-control border-dark" id="match-duration"
                                name="match_duration" min="0" value="{{ $rule->match_duration }}" disabled />
                        </div>
                    </div>
                    <div class="matches-day-min col-md">
                        <div class="floating-label">
                            <label for="matches-day-min">@lang('messages.matches_day_min')</label>
                            <input type="number" class="form-control border-dark" id="matches-day-min"
                                name="matches_day_min" min="0" value="{{ $rule->matches_day_min }}" disabled />
                        </div>
                    </div>
                    <div class="matches-day-max col-md">
                        <div class="floating-label">
                            <label for="matches-day-max">@lang('messages.matches_day_max')</label>
                            <input type="number" class="form-control border-dark" id="matches-day-max"
                                name="matches_day_max" min="0" value="{{ $rule->matches_day_max }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="team-matches-day-round-min col-md">
                        <div class="floating-label">
                            <label for="team-matches-day-round-min">@lang('messages.team_matches_day_round_min')</label>
                            <input type="number" class="form-control border-dark" id="team-matches-day-round-min"
                                name="team_matches_day_round_min" min="0"
                                value="{{ $rule->team_matches_day_round_min }}" disabled />
                        </div>
                    </div>
                    <div class="team-matches-day-round-max col-md">
                        <div class="floating-label">
                            <label for="team-matches-day-round-max">@lang('messages.team_matches_day_round_max')</label>
                            <input type="number" class="form-control border-dark" id="team-matches-day-round-max"
                                name="team_matches_day_round_max" min="0"
                                value="{{ $rule->team_matches_day_round_max }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="match-days-times col-md">
                        <div class="floating-label">
                            <label for="match-days-times">@lang('messages.match_days_times')</label>
                            <input type="text" class="form-control border-dark" id="match-days-times"
                                name="match_days_times" value="{{ $rule->match_days_times }}" disabled />
                        </div>
                    </div>
                    <div class="case_of_draw col-md">
                        <div class="floating-label">
                            <label for="case-of-draw">
                                @lang('messages.case_of_draw')
                            </label>
                            <select class="form-control border-dark" id="case-of-draw" name="case_of_draw" disabled>
                                <option {{ $rule->case_of_draw === 'draw' ? "selected" : "" }} value="draw">
                                    @lang('messages.draw')
                                </option>
                                <option {{ $rule->case_of_draw === 'additional_time' ? "selected" : "" }}
                                    value="additional_time">
                                    @lang('messages.additional_time')
                                </option>
                                <option {{ $rule->case_of_draw === 'penalties' ? "selected" : "" }} value="penalties">
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
                            <input type="text" class="form-control input-datepicker border-dark" id="start-date"
                                name="start_date" value="{{ $rule->start_date }}" disabled />
                        </div>
                    </div>
                    <div class="end-date col-md">
                        <div class="floating-label">
                            <label for="end-date">@lang('messages.end_date')</label>
                            <input type="text" class="form-control input-datepicker border-dark" id="end-date"
                                name="end_date" value="{{ $rule->end_date }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="break-start-date col-md">
                        <div class="floating-label">
                            <label for="break-start-date">@lang('messages.break_start_date')</label>
                            <input type="text" class="form-control input-datepicker border-dark" id="break-start-date"
                                name="break_start_date" value="{{ $rule->break_start_date }}" disabled />
                        </div>
                    </div>
                    <div class="break-end-date col-md">
                        <div class="floating-label">
                            <label for="break-end-date">@lang('messages.break_end_date')</label>
                            <input type="text" class="form-control input-datepicker border-dark" id="break-end-date"
                                name="break_end_date" value="{{ $rule->break_end_date }}" disabled />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection